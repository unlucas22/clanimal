<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Bill, ProductForSale, Product, ProductDetail};
use Illuminate\Support\Facades\{Auth, Log};
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SaleStoreRequest;
use App\Traits\NubeFact;
use DB;

class SaleController extends Controller
{
    use NubeFact;

    public function store(SaleStoreRequest $req)
    {
        DB::beginTransaction();

        try
        {
            /* Colaborador Referido */
            $user_referente = null;

            if($req->user_referente !== null)
            {
                $user_referente = (User::where('name', $req->user_referente)->first())->id;
            }
            
            $bill = Bill::create([
                'client_id' => $req->client_id,
                'metodo_de_pago' => $req->radio,
                'user_id' => Auth::user()->id,
                'referente_id' => $user_referente,
                'total' => $req->total,
                'igv' => $req->igv,
                'razon_social' => $req->cliente_razon_social ?? null,
                'ruc' => $req->cliente_ruc ?? null,
                'tarjeta' => $req->tarjeta ?? null,
            ]);

            /* Asignar productos comprados a la venta */
            $products = $this->asignProductToBill($req->productos_guardados, $bill->id);

            /* generar factura o boleta */
            $factura = $this->generarFactura($bill);

            DB::commit();

            if($factura == null)
            {
                return Redirect::back()->withErrors('Hubo un error con NubeFact');
            }

            // Enlace de la factura en nubefact
            $enlace = 'https://www.nubefact.com/cpe/'.$factura['key'];

            Bill::where('id', $bill->id)->update([
                'enlace' => $enlace,
            ]);
            
            return redirect()->route('dashboard.show.venta.factura', [
                'bill_id' => $bill->id
            ]);

        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
            DB::rollback();
        }
    }

    public function show(Request $req)
    {
        $bill = Bill::with(['clients', 'users', 'product_for_sales'])->where('id', $req->bill_id)->first();

        return view('show.comprobante', [
            'bill' => $bill
        ]);
    }

    public function asignProductToBill($ids, $bill_id)
    {
        $products = [];

        $ids_array = explode(',', $ids);

        // Eliminar espacios en blanco y asegurarse de que cada elemento sea único
        $unique_ids = array_map('trim', array_unique($ids_array));

        foreach ($unique_ids as $id)
        {
            ProductForSale::where('id', $id)->update([
                'bill_id' => $bill_id
            ]);

            $product_for_sale = ProductForSale::with('product_details')->where('id', $id)->first();

            /*Product::where('id', $product_for_sale->product_details->product_id)->update([
                'stock' => $product_for_sale->product_details->products->stock - $product_for_sale->cantidad,
            ]);*/

            $products[] = $product_for_sale;
        }

        return $products;
    }
}

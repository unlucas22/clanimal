<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Sale, Bill, ProductForSale};
use App\Traits\NubeFact;
use Illuminate\Support\Facades\{Auth, Log};
use DB;
use Illuminate\Support\Facades\Redirect;

class SaleController extends Controller
{
    use NubeFact;

    public function store(Request $req)
    {
        DB::beginTransaction();

        try {

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
            ]);

            /* Asignar productos comprados a la venta */
            $products = $this->asignProductToBill($req->productos_guardados, $bill->id);

            /* generar factura o boleta */
            $factura = $this->generarFactura($bill);

            if($factura == null)
            {
                return Redirect::back()->withErrors('Hubo un error con NubeFact');
            }

            $bill = Bill::update([
                'enlace' => $factura->enlace,
            ]);

            DB::commit();
            
            return Redirect::to($factura->enlace);

        } catch (\Exception $e) {
            DB::rollback();

            ddd($e->getMessage());
        }
    }

    public function show(Request $req)
    {
        $bill = Bill::with(['clients', 'users', 'product_for_sales'])->where('id', $req->bill_id)->first();

        return Redirect::to($bill->enlace);
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

            $products[] = ProductForSale::where('id', $id)->first();
        }

        return $products;
    }
}

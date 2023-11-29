<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, ProductBrand, ProductCategory, ProductDetail, ProductPresentation, Warehouse, ProductInWarehouse};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use DB;
use App\Http\Requests\ProductStoreRequest;


class ProductController extends Controller
{
    /**
     * Compras realizadas a proveedor
     * */
    public function storeWarehouse(ProductStoreRequest $req)
    {
        DB::beginTransaction();

        ddd($req);

        try {
            $warehouse = Warehouse::create([
                'user_id' => Auth::user()->id,
                'supplier_id' => $req->supplier_id,
                // 'stock' => $req->stock, Actualizar esto al momento de asignar a productos
                'fecha' => $req->fecha,
                'factura' => $req->factura,
                'total' => $req->total,
                'status' => $req->status ?? 'pendiente',
            ]);

            /* Asignar productos comprados al almacen */
            $products = [];

            for ($i=0; $i < intval($req->product_details); $i++)
            { 
                $product = Product::where('id', $id)->update([
                    'name' => $req->product_name[$i],
                    // 'product_brand_id',
                    // 'product_category_id',
                    'user_id' => Auth::user()->id,
                    'precio_compra' => $req->precio_compra[$i],
                    'precio_venta' => $req->precio_venta[$i],
                    // 'stock' => $req->stock[$i],
                ]);

                $products_in_warehouse = ProductInWarehouse::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {

            Log::info($e->getMessage());

            ddd($e->getMessage());

            DB::rollback();
        }
    }

    /**
     * Se crea el producto con los detalles basicos para despues ser completados en productos
     * */
    public function asignProductToWarehouse($ids, $warehouse_id)
    {
        $products = [];

        // en un principio no se utilizaria en el return
        $products_in_warehouse = [];

        $ids_array = explode(',', $ids);

        // Eliminar espacios en blanco y asegurarse de que cada elemento sea único
        $unique_ids = array_map('trim', array_unique($ids_array));

        foreach ($unique_ids as $id)
        {
            

            $products[] = Product::where('id', $id)->first();

            // asignar al warehouse
            $products_in_warehouse[] = ProductInWarehouse::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse_id,
            ]);

        }

        return [$products, $products_in_warehouse];
    }

    public function store(Request $req)
    {
        DB::beginTransaction();

        try {


            $product_brand = ProductBrand::where('name', $req->product_brand_id)->firstOrFail();

            $product_category = ProductCategory::where('name', $req->product_category_id)->firstOrFail();

            $photo_path = null;

            $input = "photo";

            if($req->file($input) != null)
            {
                $photo_path = $this->storeImage($req, $input);
            }

            $fecha = Carbon::parse($req->fecha.' '.Carbon::now()->format('H:i:s'));

            $product = Product::create([
                'name' => $req->name,
                'product_brand_id' => $product_brand->id,
                'product_category_id' => $product_category->id,
                'product_presentation_id' => intval($req->product_presentation_id),
                // 'product_detail_id' => null,
                'active' => $req->active == 'on' ? true : false,
                'user_id' => Auth::user()->id,
                'precio_compra' => $req->precio_compra,
                'precio_venta' => $req->precio_venta ?? $req->precio_compra,
                'stock' => $req->amount,
                'barcode' => $req->barcode ?? null,
                'palabras_clave' => $req->palabras_clave ?? null,
                'fecha_de_vencimiento' => $fecha,
                'alerta_stock' => $req->alerta_stock,
                'photo_path' => $photo_path,
                'amount_presentation' => $req->amount_presentation,
            ]);

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                ProductDetail::create([
                    'product_id' => $product->id,
                    'product_presentation_id' => $req->product_presentation_details_id[$i],
                    'amount' => $req->amount_details[$i],
                    'discount' => $req->discount_details[$i],
                    'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                    //'precio_venta_con_igv' => $req->precio_venta_con_igv_details[$i],
                    'precio_venta_con_igv' => $req->precio_venta_details[$i] + ($req->precio_venta_details[$i]*0.18)
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard.products');

        } catch (\Exception $e) {

            DB::rollback();

            \Log::error($e->getMessage());

            return back();
        }
    }

    /**
     * Guarda los archivos con un filename unico
     * Y los inserta en storage/pets
     * 
     * @param Request $req
     *  
     * @return \App\Models\Image
     * 
     * */
    protected function storeImage($req, $input)
    {
        $req->validate([
            $input => 'mimes:jpg,png,jpeg'
        ]);

        $fileName = uniqid() . '-' .$req->file($input)->getClientOriginalName();

        $path = $req->file($input)->storeAs('uploads', $fileName, 'public');

        return $path;
    }
}

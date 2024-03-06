<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, ProductBrand, ProductCategory, ProductDetail, ProductPresentation, Warehouse, ProductInWarehouse};
use Illuminate\Support\Facades\{Auth, Log};
use App\Http\Requests\ProductStoreRequest;
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
    /**
     * Compras realizadas a proveedor
     * */
    public function storeWarehouse(ProductStoreRequest $req)
    {
        DB::beginTransaction();

        try {

            $total = 0;

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                $total += $req->precio_venta_details[$i] + ($req->precio_venta_details[$i] * (18/100));
            }

            $fecha = Carbon::parse($req->fecha);

            $warehouse = Warehouse::create([
                'user_id' => Auth::user()->id,
                'supplier_id' => $req->supplier_id,
                'fecha' => $fecha,
                'key_type' => $req->key_type,
                'value_type' => $req->value_type,
                'status' => $req->status ?? 'pendiente',
            ]);

            /* Asignar productos comprados al almacen */
            $products = [];
            $product_details = [];

            $products_in_warehouse = [];

            $product_name = explode(',', $req->product_name);

            if(count($product_name) != intval($req->product_details))
            {
                ddd('error: discrepancia. l.49');
            }

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                $product_base = Product::where('name', $product_name[$i])->first();

                $precio_venta_con_igv = $req->precio_venta_details[$i] + ($req->precio_venta_details[$i]*0.18);

                Product::where('name', $product_name[$i])->update([
                    'stock' => $product_base->stock + $req->amount_details[$i],
                    'precio_venta' => $req->precio_venta_details[$i],
                    'product_brand_id' => $req->product_brand_details_id[$i],
                ]);

                $product_details[] = ProductDetail::create([
                    'product_id' => $product_base->id,
                    'amount' => $req->amount_details[$i],
                    'product_presentation_id' => $req->product_presentation_details_id[$i],
                    'discount' => $req->discount_details[$i],
                    'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                    'precio_venta_con_igv' => $precio_venta_con_igv,
                    'fecha_de_vencimiento' => $req->fecha_de_vencimiento[$i],
                ]);

                $products_in_warehouse[] = ProductInWarehouse::create([
                    'product_id' => $product_base->id,
                    'warehouse_id' => $warehouse->id,
                ]);
            }

            Warehouse::where('id', $warehouse->id)->update([
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('dashboard.compras');

        } catch (\Exception $e) {

            Log::info($e);

            DB::rollback();

            return back();

            //ddd($e->getMessage());
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

    public function update(Request $req)
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

                Product::where('id', $req->product_id)->update([
                    'photo_path' => $photo_path,
                ]);
            }

            // $fecha = Carbon::parse($req->fecha.' '.Carbon::now()->format('H:i:s'));

            $product = Product::where('id', $req->product_id)->update([
                'name' => $req->name,
                'product_brand_id' => $product_brand->id,
                'product_category_id' => $product_category->id,
                'product_presentation_id' => (ProductPresentation::where('name', 'Sin especificar')->first())->id, //intval($req->product_presentation_id),
                'active' => $req->active == 'on' ? true : false,
                'user_id' => Auth::user()->id,
                // 'precio_compra' => $req->precio_compra,
                'precio_venta' => $req->precio_venta ?? 0,
                //'stock' => $req->amount,
                'barcode' => $req->barcode ?? null,
                'palabras_clave' => $req->palabras_clave ?? null,
                // 'fecha_de_vencimiento' => $fecha,
                'alerta_stock' => $req->alerta_stock,
                //'amount_presentation' => $req->amount_presentation,
            ]);

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                ProductDetail::updateOrCreate([
                    'product_id' => $req->product_id,
                    'product_presentation_id' => $req->product_presentation_details_id[$i],
                ], [
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

    //
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

            // $fecha = Carbon::parse($req->fecha.' '.Carbon::now()->format('H:i:s'));

            $product = Product::create([
                'name' => $req->name,
                'product_brand_id' => $product_brand->id,
                'product_category_id' => $product_category->id,
                // 'product_presentation_id' => intval($req->product_presentation_id),
                'product_presentation_id' => (ProductPresentation::where('name', 'Sin especificar')->first())->id,
                // 'product_detail_id' => null,
                'active' => $req->active == 'on' ? true : false,
                'user_id' => Auth::user()->id,
                //'precio_compra' => $req->precio_compra ?? 0,
                'precio_venta' => $req->precio_venta ?? 0,
                // 'stock' => $req->amount ?? 0,
                'barcode' => $req->barcode ?? null,
                'palabras_clave' => $req->palabras_clave ?? null,
                // 'fecha_de_vencimiento' => $fecha,
                'alerta_stock' => $req->alerta_stock,
                'photo_path' => $photo_path,
                //'amount_presentation' => $req->amount_presentation,
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

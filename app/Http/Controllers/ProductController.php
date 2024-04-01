<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, ProductBrand, ProductCategory, ProductDetail, ProductPresentation, Warehouse, ProductInWarehouse, ProductStock};
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

        try
        {
            $total = 0;
            
            /* Calcula el total de Venta */
            for ($i=0; $i < intval($req->product_details); $i++)
            {
                $total += ($req->precio_venta_details[$i] * $req->amount_details[$i]) + ($req->precio_venta_details[$i] * (18/100));
            }

            /* Parsear fecha con Hora y minutos */
            $fecha = Carbon::parse($req->fecha);

            /* Ruc es opcional, de ser asi toma el ruc del proveedor */
            $warehouse = Warehouse::create([
                'user_id' => Auth::user()->id,
                'supplier_id' => $req->supplier_id,
                'fecha' => $fecha,
                'key_type' => $req->key_type,
                'value_type' => $req->value_type,
                'status' => $req->status ?? 'pendiente',
            ]);

            /* Toma del input string separados con coma para separarlos en un array */
            $product_name = explode(',', $req->product_name);

            /*
             No concuerda los nombres de los productos con el total que hay en un input hidden que se llama product_details 
            */
            if(count($product_name) != intval($req->product_details))
            {
                // Es un error que ocurriría si se modifica manualmente el input hidden, por eso el debug
                ddd('error: discrepancia');
            }

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                $product_base = Product::where('name', $product_name[$i])->first();

                // Se hace el calculo de impuestos
                $precio_venta_con_igv = $req->precio_venta_details[$i] + ($req->precio_venta_details[$i]*0.18);

                // se asignan al almacen
                $piw = ProductInWarehouse::create([
                    'product_id' => $product_base->id,
                    'warehouse_id' => $warehouse->id,
                    'product_presentation_id' => $req->product_presentation_details_id[$i],
                    'amount' => $req->amount_details[$i],
                    'discount' => $req->discount_details[$i],
                    'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                    'precio_venta_con_igv' => $precio_venta_con_igv,
                    'fecha_de_vencimiento' => $req->fecha_de_vencimiento[$i],
                ]);

                // se asigna al stock
                ProductStock::create([
                    'product_in_warehouse_id' => $piw->id,
                    'stock' => $piw->amount,
                ]);
            }

            // Este model actua como Historial de los productos ingresados
            Warehouse::where('id', $warehouse->id)->update([
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('dashboard.compras');
        } 
        catch (\Exception $e)
        {
            Log::info($e);

            DB::rollback();

            return back();
        }
    }

    /**
     * Se crea el producto con los subProductos para despues ser completados en productos
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

    /**
     * Actualizar Producto y SubProductos,
     * no hay opcion para eliminar SubProductos
     * */
    public function update(Request $req)
    {
        DB::beginTransaction();

        try
        {
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

            Product::where('id', $req->product_id)->update([
                'name' => $req->name,
                'product_brand_id' => $product_brand->id,
                'product_category_id' => $product_category->id,
                'product_presentation_id' => (ProductPresentation::where('name', 'Sin especificar')->first())->id,
                'active' => $req->active == 'on' ? true : false,
                'user_id' => Auth::user()->id,
                'precio_venta' => $req->precio_venta ?? 0,
                'barcode' => $req->barcode ?? null,
                'palabras_clave' => $req->palabras_clave ?? null,
                'alerta_stock' => $req->alerta_stock,
            ]);

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                /* se calculan los impuestos */
                $precio_venta_con_igv = $req->precio_venta_details[$i] + ($req->precio_venta_details[$i]*0.18);

                if(ProductDetail::where('product_id', $req->product_id)->where('product_presentation_id', $req->product_presentation_details_id[$i],)->count())
                {
                    ProductDetail::where('product_id', $req->product_id)->where('product_presentation_id', $req->product_presentation_details_id[$i],)->update([
                        'amount' => $req->amount_details[$i],
                        'discount' => $req->discount_details[$i],
                        'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                        'precio_venta_con_igv' => $precio_venta_con_igv,
                    ]);
                }
                else
                {
                    ProductDetail::create([
                        'product_id' => $req->product_id,
                        'product_presentation_id' => $req->product_presentation_details_id[$i],
                        'amount' => $req->amount_details[$i],
                        'discount' => $req->discount_details[$i],
                        'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                        'precio_venta_con_igv' => $precio_venta_con_igv,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard.products');
        }
        catch (\Exception $e)
        {
            DB::rollback();

            \Log::error($e->getMessage());

            return back();
        }
    }

    /**
     * Registrar Productos con Subproductos, 
     * no se cuentan los stock de cada unidad pero si el total de las ventas
     * */
    public function store(Request $req)
    {
        DB::beginTransaction();

        try
        {
            /* carga de imagen */
            $photo_path = null;

            $input = "photo";

            if($req->file($input) != null)
            {
                $photo_path = $this->storeImage($req, $input);
            }
            
            $product_brand = ProductBrand::where('name', $req->product_brand_id)->firstOrFail();

            $product_category = ProductCategory::where('name', $req->product_category_id)->firstOrFail();

            $product = Product::create([
                'name' => $req->name,
                'product_brand_id' => $product_brand->id,
                'product_category_id' => $product_category->id,
                'product_presentation_id' => (ProductPresentation::where('name', 'Sin especificar')->first())->id,
                'active' => $req->active == 'on' ? true : false,
                'user_id' => Auth::user()->id,
                'precio_venta' => $req->precio_venta ?? 0,
                'barcode' => $req->barcode ?? null,
                'palabras_clave' => $req->palabras_clave ?? null,
                'alerta_stock' => $req->alerta_stock,
                'photo_path' => $photo_path,
            ]);

            for ($i=0; $i < intval($req->product_details); $i++)
            {
                /* se calculan los impuestos */
                $precio_venta_con_igv = $req->precio_venta_details[$i] + ($req->precio_venta_details[$i]*0.18);

                if(ProductDetail::where('product_id', $product->id)->where('product_presentation_id', $req->product_presentation_details_id[$i],)->count())
                {
                    ProductDetail::where('product_id', $product->id)->where('product_presentation_id', $req->product_presentation_details_id[$i],)->update([
                        'amount' => $req->amount_details[$i],
                        'discount' => $req->discount_details[$i],
                        'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                        'precio_venta_con_igv' => $precio_venta_con_igv,
                    ]);
                }
                else
                {
                    ProductDetail::create([
                        'product_id' => $product->id,
                        'product_presentation_id' => $req->product_presentation_details_id[$i],
                        'amount' => $req->amount_details[$i],
                        'discount' => $req->discount_details[$i],
                        'precio_venta_sin_igv' => $req->precio_venta_details[$i],
                        'precio_venta_con_igv' => $precio_venta_con_igv,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard.products');

        }
        catch (\Exception $e)
        {
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
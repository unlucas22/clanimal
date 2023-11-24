<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, ProductBrand, ProductCategory, ProductDetail, ProductPresentation};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
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

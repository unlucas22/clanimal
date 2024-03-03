<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Models\{ProductBrand, ProductCategory, ProductPresentation, ProductDetail};
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Product extends Component
{
    public $product_presentation_id;
    
    public $name;
    public $palabras_clave;
    public $barcode;

    public $amount;
    public $amount_presentation;

    public $precio_compra;
    public $alerta_stock;

    /* foreach por cada id */
    public $product_details;

    public $amount_details = [];

    public $discount_details = [];

    public $precio_venta_details = [];

    public $precio_venta_con_igv_details = [];

    public $product_presentation_details_id = [];

    public $listeners = ['getBarcode', 'refreshParent', 'refreshComponent' => '$refresh'];

    public $product = [];

    public $rules = [
        'product_presentation_id' => 'required',
        
        'name' => 'required',
        'palabras_clave' => 'required',

        'barcode' => 'required|unique:products',
        'amount' => 'required',
        'amount_presentation' => 'required',
        'precio_compra' => 'required',
        'alerta_stock' => 'nullable',
    ];

    public function agregarPrecio()
    {
        ++$this->product_details;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;
    }

    public function refreshParent()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();

        $this->product_categories = ProductCategory::where('active', true)->get();

        $this->dispatchBrowserEvent('updateBrand', ['value' => (ProductBrand::orderBy('created_at', 'desc')->first())->name ]);
        $this->dispatchBrowserEvent('updateCategory', ['value' => (ProductCategory::orderBy('created_at', 'desc')->first())->name]);
    }

    /* Select options */
    public function mount(Request $req)
    {
        $product = \App\Models\Product::with(['product_presentations', 'product_categories', 'product_details', 'product_brands'])->hashid($req->hashid)->firstOrFail();


        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        // $this->product_brand_id = $product->product_brand_id;
        // $this->product_category_id = $product->product_category_id;
        $this->product_presentation_id = $product->product_presentation_id;

        $this->name = $product->name;
        $this->palabras_clave = $product->palabras_clave;
        $this->barcode = $product->barcode;

        $this->amount = $product->stock;
        $this->amount_presentation = $product->amount_presentation;

        $this->precio_compra = $product->precio_compra;
        $this->alerta_stock = $product->alerta_stock;

        $this->product_details = count($product->product_details);

        foreach ($product->product_details as $product_detail)
        {
            $this->amount_details[] = $product_detail->amount;

            $this->discount_details[] = $product_detail->discount;

            $this->precio_venta_details[] = $product_detail->precio_venta_sin_igv;

            $this->precio_venta_con_igv_details[] = $product_detail->precio_venta_con_igv;

            $this->product_presentation_details_id[] = $product_detail->product_presentation_id;
        }

        $this->product = $product;

    }

    public $product_brands;
    public $product_categories;

    public function render()
    {
        return view('livewire.dashboard.show.product', [
            'product_brands' => $this->product_brands,
            'product_categories' => $this->product_categories,
            'product_presentations' => ProductPresentation::get(),
        ]);
    }

    public function getBarcode()
    {
        $barcode = random_int(100000000000, 999999999999);

        /* verificar que el barcode no existe */
        while (\App\Models\Product::where('barcode', $barcode)->count())
        {
            $barcode = random_int(100000000000, 999999999999);
        }

        $this->barcode = $barcode;
    }

    public function submit()
    {
        $this->validate();

        return true;
    }
}

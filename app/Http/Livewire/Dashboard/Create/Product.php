<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{ProductBrand, ProductCategory, ProductPresentation, ProductDetail};

class Product extends Component
{
    // public $product_brand_id;
    // public $product_category_id;
    public $product_presentation_id;
    
    public $name;
    public $palabras_clave;
    public $barcode = null;

    public $amount = 1;
    public $amount_presentation = 1;

    public $precio_compra = 1;
    public $alerta_stock = 1;

    /* foreach por cada id */
    public $product_details = 1;

    public $amount_details = [
        1
    ];

    public $discount_details = [
        0
    ];

    public $precio_venta_details = [
        0
    ];

    public $precio_venta_con_igv_details = [
        0
    ];

    public $product_presentation_details_id = [
        1
    ];

    public $listeners = ['getBarcode', 'refreshParent', 'refreshComponent' => '$refresh'];

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

    public function refreshParent()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();

        $this->product_categories = ProductCategory::where('active', true)->get();

        $this->dispatchBrowserEvent('updateBrand', ['value' => (ProductBrand::orderBy('created_at', 'desc')->first())->name ]);
        $this->dispatchBrowserEvent('updateCategory', ['value' => (ProductCategory::orderBy('created_at', 'desc')->first())->name]);
    }

    public function agregarPrecio()
    {
        ++$this->product_details;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;
    }

    /* Select options */
    public function mount()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        $this->product_brand_id = (ProductBrand::first())->id ?? null;
        $this->product_category_id = (ProductCategory::first())->id ?? null;
        $this->product_presentation_id = (ProductPresentation::first())->id ?? null;
    }

    public $product_brands;
    public $product_categories;

    public function render()
    {
        return view('livewire.dashboard.create.product', [
            'product_brands' => $this->product_brands,
            'product_categories' => $this->product_categories,
            'product_presentations' => ProductPresentation::get(),
        ]);
    }

    public function getBarcode()
    {
        $this->barcode = random_int(100000000000, 999999999999);
    }

    public function submit()
    {
        $this->validate();

        return true;
    }
}

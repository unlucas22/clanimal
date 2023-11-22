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

    public $precio_compra;
    public $alerta_stock = 1;

    public $listeners = ['getBarcode'];

    public $rules = [
        'product_presentation_id' => 'required',
        
        'name' => 'required',
        'palabras_clave' => 'required',

        'barcode' => 'required',
        'amount' => 'required',
        'amount_presentation' => 'required',
        'precio_compra' => 'required',
        'alerta_stock' => 'nullable',
    ];

    public function mount()
    {
        $this->product_brand_id = (ProductBrand::first())->id ?? null;
        $this->product_category_id = (ProductCategory::first())->id ?? null;
        $this->product_presentation_id = (ProductPresentation::first())->id ?? null;
    }

    public function render()
    {
        return view('livewire.dashboard.create.product', [
            'product_brands' => ProductBrand::where('active', true)->get(),
            'product_categories' => ProductCategory::get(),
            'product_presentations' => ProductPresentation::get(),
        ]);
    }

    public function getBarcode()
    {
        /* de prueba */
        $this->barcode = 4445645656;
    }

    public function submit()
    {
        $this->validate();

        return true;
    }
}

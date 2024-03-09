<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{ProductBrand, ProductCategory, ProductPresentation, ProductDetail};

class Product extends Component
{
    /*** Datos del Producto ***/
    public $product_presentation_id;
    public $name;
    public $palabras_clave;
    public $barcode = null;
    public $alerta_stock = 1;

    /* Stock */
    public $amount = 1;
    /* Stock por Presentacion */
    public $amount_presentation = 1;

    /* ¿Precio compra en 0 siempre? */
    public $precio_compra = 1;

    /*** Datos de SubProductos ***/

    /* Se hace un foreach por cada id en el Controlador */
    public $product_details = 1;

    /* Stock */
    public $amount_details = [
        1
    ];
    /* Descuento */
    public $discount_details = [
        0
    ];
    /* Precio de Venta */
    public $precio_venta_details = [
        0
    ];
    /* Precio de Venta con impuestos */
    public $precio_venta_con_igv_details = [
        0
    ];
    /* Tipo de Presentacion */
    public $product_presentation_details_id = [
        1
    ];

    /* Datalist */
    public $product_brands;
    public $product_categories;

    public $listeners = ['getBarcode', 'refreshParent', 'refreshComponent' => '$refresh'];

    public $rules = [
        'product_presentation_id' => 'required',
        'name' => 'required',
        'palabras_clave' => 'required',
        'barcode' => 'required|unique:products',
        'alerta_stock' => 'nullable',
        'amount' => 'required',

        'amount_presentation' => 'required',
        'precio_compra' => 'required',
    ];

    /* Hace referencia a los datalist */
    public function refreshParent()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        //  Actualiza las marcas del datalist
        $this->dispatchBrowserEvent('updateBrand', [
            'value' => (ProductBrand::orderBy('created_at', 'desc')->first())->name
        ]);

        //  Actualiza las categorias del datalist
        $this->dispatchBrowserEvent('updateCategory', [
            'value' => (ProductCategory::orderBy('created_at', 'desc')->first())->name
        ]);
    }

    /***
     *  Añadir o Remover SubProductos
     * Faltaria pulir esta parte
     * */
    public function agregarPrecio()
    {
        ++$this->product_details;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;
    }

    /* Montar los Select options y datalist */
    public function mount()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        /* Valores Default */
        $this->product_brand_id = (ProductBrand::first())->id ?? null;
        $this->product_category_id = (ProductCategory::first())->id ?? null;
        $this->product_presentation_id = (ProductPresentation::first())->id ?? null;
    }

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

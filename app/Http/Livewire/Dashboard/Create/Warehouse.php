<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Supplier, ProductPresentation, ProductBrand, Product};

class Warehouse extends Component
{
    /* datos del proveedor y del cliente */
    public $factura;
    public $supplier_id;

    public $status = 'pendiente';

    public $name;
    public $palabras_clave;
    public $barcode = null;

    public $key_type;
    public $value_type;

    public $cedula;

    public $total = 0;

    public $amount = 0;
    public $amount_presentation = 0;
    
    public $product_presentation_id;

    /* foreach por cada id */
    public $product_details = 0;

    /* EN UN FUTURO DESAPARECE codigo: (27-46) por una tabla como ocurre en Ventas */
    public $amount_details = [
        //1
    ];

    /* Descuento */
    public $discount_details = [
        //0
    ];

    /* Precio venta */
    public $precio_venta_details = [
        //0
    ];

    /* Precio de cada venta con impuestos */
    public $precio_venta_total = [
        //0
    ];

    /* Precio de cada producto */
    public $precio_compra = [
        //1
    ];

    public $product_presentation_details_id = [
        //1
    ];

    public $product_brand_details_id = [
        //1
    ];

    public $product_name = [
        //''
    ];

    public $product_search = '';

    public $listeners = ['getBarcode', 'productSelected'];

    public $rules = [
        'product_presentation_id' => 'required',
        
        'name' => 'required',

        'amount' => 'required',
        'amount_presentation' => 'required',
        'precio_compra' => 'required',
    ];

    public function productSelected($value)
    {
        $this->product_search = $value;
    }

    public function agregarPrecio()
    {
        ++$this->product_details;

        $this->product_name[] = $this->product_search;

        $product = Product::with('product_brands')->where('name', $this->product_search)->first();

        $this->product_brand_details_id[] = $product->product_brands->name;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;

        $this->product_name = array_slice($this->product_name, 0, -1);
    }

    public function setTotal($item_id, $value)
    {
        for ($i=0; $i < intval($this->product_details); $i++)
        {
            $sum = $this->precio_venta_details[$i] + ($this->precio_venta_details[$i] * (18/100));

            $this->total += ($sum - $this->discount_details[$i]);
        }

        $this->precio_venta_total[$item_id] = $value;
    }

    /* Select options */
    public function mount()
    {
        $this->product_presentation_id = (ProductPresentation::first())->id ?? null;

        $this->supplier_id = (Supplier::first())->id ?? null;
    }

    public function render()
    {
        return view('livewire.dashboard.create.warehouse', [
            'suppliers' => Supplier::get(),
            'product_presentations' => ProductPresentation::get(),
            'product_brands' => ProductBrand::get(),
            'products' => Product::get(),
        ]);
    }
}

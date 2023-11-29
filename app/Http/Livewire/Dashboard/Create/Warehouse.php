<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Supplier, ProductPresentation};

class Warehouse extends Component
{
    /* datos del proveedor y del cliente */
    public $factura;
    public $supplier_id;

    public $total = 0;
    
    public $name;
    public $palabras_clave;
    public $barcode = null;

    public $amount = 1;
    public $amount_presentation = 1;

    public $precio_compra;
    public $alerta_stock = 1;

    public $product_presentation_id;

    /* foreach por cada id */
    public $product_details = 2;

    /* EN UN FUTURO DESAPARECE codigo: (27-46) por una tabla como ocurre en Ventas */
    public $amount_details = [
        1, 2
    ];

    public $discount_details = [
        0, 0
    ];

    public $precio_venta_details = [
        0, 0
    ];

    public $precio_venta_total = [
        0, 0
    ];

    public $product_presentation_details_id = [
        1, 2
    ];

    public $product_name = [
        '', ''
    ];

    public $listeners = ['getBarcode'];

    public $rules = [
        'product_presentation_id' => 'required',
        
        'name' => 'required',

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
        ]);
    }
}

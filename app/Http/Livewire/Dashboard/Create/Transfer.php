<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Product, Company, ProductDetail, ProductForTransfer};
use Illuminate\Support\Facades\Log;

class Transfer extends Component
{
    /* Busqueda */
    public $search;
    public $dni;

    public $transfer_id;

    /* Productos */
    public $products = [];
    public $productos_guardados = [];

    public $listeners = ['agregarProducto', 'retirarProductoParaCompra'];

    public function mount()
    {
        $this->products = $this->getProducts();
    }

    public function render()
    {
        /* productos guardados para la venta */
        $productos_para_compra = [];

        foreach ($this->productos_guardados as $producto)
        {
            $product_model = Product::select('*', 'barcode as stock')->with(['product_details'])->where('id', $producto['id'])->first();

            $product_model->stock = $producto['cantidad'];

            $productos_para_compra[] = $product_model;
        }

        return view('livewire.dashboard.create.transfer', [
            'products' => $this->products,
            'productos_para_compra' => $productos_para_compra,
            'sedes' => Company::get(),
        ]);
    }

    /**
     * Buscar el cliente registrado por dni
     *  */
    public function searchClient() {

        $client = Client::with('pets')->where('dni', $this->dni)->first();

        if($client != null)
        {
            $this->client_name = $client->name;
            $this->client_id = $client->id;

            $this->pets = $client->pets;
        }
        else
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'No se encontró al cliente',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

    public function agregarProducto($item_id, $cantidad = 1)
    {
        try {

            $product_for_transfer = [
                'id' => $item_id,
                'cantidad' => $cantidad
            ];

            $this->productos_guardados[] = $product_for_transfer;
            
            $this->emit('refreshComponent');

        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

    }

    public function buscarProductos()
    {
        if($this->search != null)
        {
            $this->products = Product::with(['product_presentations', 'product_details'])/*->withStock()*/->where('name', 'like', '%'.$this->search.'%')->orWhere('palabras_clave', 'like', '%'.$this->search.'%')->get();
        }
        else
        {
            $this->products = $this->getProducts();
        }
        
        $this->emit('refreshComponent');
    }

    public function retirarProductoParaCompra($item_id)
    {
        try {

            foreach ($this->productos_guardados as $index => $producto)
            {
                if($item_id == $producto['id'])
                {
                    array_splice($this->productos_guardados, $index, 1);
                }
            }

            $this->emit('refreshComponent');

        } catch (\Exception $e) {
            Log::info($e->getMessage());   
        }
    }

    public function getProducts()
    {
        return Product::with(['product_presentations', 'product_details'])/*->withStock()*/->get();
    }
}

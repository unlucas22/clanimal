<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
use App\Models\{Product, Client, User, ProductDetail, ProductForSale};

class Productos extends Component
{
    public $dni;
    public $client_id;

    public $client_name;

    public $search;

    public $pets = [];
    public $pet_id;

    public $user_referente;

    public $total = 0;

    public $client_razon_social;

    public $client_ruc;

    public $products = [];

    public $factura = true;

    public $productos_guardados = [];

    public $listeners = ['agregarProducto', 'retirarProductoParaCompra'];

    public function mount()
    {
        $this->products = Product::with(['product_presentations', 'product_details'])->where('stock', '!=', 0)->get();
    }

    /**
     * Buscar el cliente por dni
     *  */
    public function searchClient() {

        $client = Client::with('pets')->where('dni', $this->dni)->first();

        if($client != null) {
            $this->client_name = $client->name;
            $this->client_id = $client->id;

            $this->pets = $client->pets;

        } else {
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
            $product_for_sale = ProductForSale::create([
                'product_detail_id' => $item_id,
                'cantidad' => $cantidad
            ]);

            $this->productos_guardados[] = $product_for_sale->id;
            
            $this->emit('refreshComponent');

            $this->setTotal();

        } catch (\Exception $e) {
            ddd($e->getMessage());
        }

    }

    public function buscarProductos()
    {
        if($this->search != null) {
            $this->products = Product::with(['product_presentations', 'product_details'])->where('name', 'like', '%'.$this->search.'%')->where('stock', '!=', 0)->get();

            $this->emit('refreshComponent');
        }else{
            $this->products = Product::with(['product_presentations', 'product_details'])->where('stock', '!=', 0)->get();

            $this->emit('refreshComponent');
        }
    }

    public function setTotal()
    {
        $total = 0;

        foreach ($this->productos_guardados as $product)
        {
            $pfs = ProductForSale::with(['product_details'])->where('id', $product)->first();

            for ($i=0; $i < $pfs->cantidad; $i++)
            { 
                $total += $pfs->product_details->descuento();
            }

        }

        $this->total = $total;
    }

    public function render()
    {
        $productos_para_compra = [];

        foreach ($this->productos_guardados as $product) {

            $productos_para_compra[] = ProductForSale::with(['product_details'])->where('id', $product)->first();
        }

        $this->setTotal();

        return view('livewire.dashboard.create.venta.productos', [
            'products' => $this->products,
            'users' => User::get(),
            'productos_para_compra' => $productos_para_compra,
        ]);
    }

    public function retirarProductoParaCompra($item_id)
    {
        try {


            foreach ($this->productos_guardados as $index => $id)
            {
                if($item_id == $id)
                {
                    array_splice($this->productos_guardados, $index, 1);

                    ProductForSale::where('id', $item_id)->delete();
                }
            }

        $this->emit('refreshComponent');

        } catch (\Exception $e) {
            ddd($e->getMessage());   
        }
    }

    public function submit()
    {
        //
    }
}

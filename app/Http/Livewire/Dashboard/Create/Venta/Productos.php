<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
use App\Models\{Product, Client, User, ProductDetail, ProductForSale};
use Illuminate\Support\Facades\Log;

class Productos extends Component
{
    /* Datos del Cliente */
    public $client_id;
    public $client_razon_social;
    public $client_ruc;
    public $client_name;
    public $client_tarjeta;

    /* Mascotas del Cliente */
    public $pets = [];
    public $pet_id;

    /* Busqueda */
    public $search;
    public $dni;

    /* Colaborador referido */
    public $user_referente;

    /* Para la caja */
    public $total = 0;
    public $igv = 0;
    public $factura = true;
    public $radio = 'efectivo';

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

        foreach ($this->productos_guardados as $product)
        {
            $productos_para_compra[] = ProductForSale::with(['product_details'])->where('id', $product)->first();
        }

        $this->setTotal();

        return view('livewire.dashboard.create.venta.productos', [
            'products' => $this->products,
            'users' => User::get(),
            'productos_para_compra' => $productos_para_compra,
        ]);
    }

    /**
     * Buscar el cliente registrado por dni
     *  */
    public function searchClient()
    {
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
        try
        {
            $product_for_sale = ProductForSale::create([
                'product_detail_id' => $item_id,
                'cantidad' => $cantidad
            ]);

            $this->productos_guardados[] = $product_for_sale->id;
            
            $this->emit('refreshComponent');
            $this->setTotal();
        }
        catch (\Exception $e)
        {
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

    /* Calcular total con impuestos y descuentos */
    public function setTotal()
    {
        $total = 0;
        /* calcula los impuestos totales */
        $igv = 0;

        foreach ($this->productos_guardados as $product)
        {
            $pfs = ProductForSale::with(['product_details'])->where('id', $product)->first();

            for ($i=0; $i < $pfs->cantidad; $i++)
            { 
                $total += $pfs->product_details->descuento();

                $igv += $pfs->product_details->diferenciaConImpuestos();
            }

        }

        $this->total = $total;
        $this->igv = $igv;
    }

    public function retirarProductoParaCompra($item_id)
    {
        try
        {
            foreach ($this->productos_guardados as $index => $id)
            {
                if($item_id == $id)
                {
                    array_splice($this->productos_guardados, $index, 1);

                    ProductForSale::where('id', $item_id)->delete();
                }
            }

            $this->emit('refreshComponent');

        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());   
        }
    }

    public function getProducts()
    {
        return Product::with(['product_presentations', 'product_details'])/*->withStock()*/->get();
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
// use App\Models\{Product, Client, User, ProductStock};
use App\Models\{Product, Client, User, Transfer, ProductForStore, ProductForTransfer, ProductStock, ProductForSale};
use Illuminate\Support\Facades\{Log, Auth};
use App\Traits\ApiRuc;

/**
 * Usar el model de ProductForStore tomando la sede del auth
 * 
 * */
class Productos extends Component
{
    use ApiRuc;

    /* Datos del Cliente */
    public $client_id;
    public $client_razon_social;
    public $client_ruc;
    public $client_name;
    public $client_credito = null;
    public $client_linea_credito = null;

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
    public $factura = false;
    public $radio = 'efectivo';

    /* Productos */
    public $products = [];
    public $productos_guardados = [];

    public $listeners = ['agregarProducto', 'retirarProductoParaCompra'];

    public function updatedClientRuc($value)
    {
        $razon_social = $this->consultarRUC($value);

        if($razon_social["resultado"] == true)
        {
            if($razon_social["denominacion"] == '-')
            {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'No se encontró el RUC',
                    'icon' => 'error',
                    'iconColor' => 'red',
                ]);
            }
            else
            {
                $this->client_razon_social = $razon_social["denominacion"];
            }
        }
    }

    public function updatedSearch($value)
    {
        $this->buscarProductos();
    }

    /**
     *  Trae del almacen los productos ingresados,
     * la facilidad que trae es que se puede filtrar en el search,
     * pero será algo lento ya que siempre debe validar que venga de
     * la sede
     * 
     * */
    public function queryParaObtenerLosProductos()
    {
        $transfers = $this->getTransfer();

        $products = [];

        foreach ($transfers as $transfer)
        {
            foreach ($transfer->product_for_transfers as $pro)
            {
                $products[] = $pro;
            }
        }

        return $products;
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
            $this->client_credito = $client->credito_actual;
            $this->client_linea_credito = $client->linea_credito;
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

        $this->products = [];
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

            $this->products = [];
            
            $this->emit('refreshComponent');
            $this->setTotal();
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }

    public function getTransfer()
    {
        $query = Transfer::query();

        $query->where('company_id', Auth::user()->company_id);

        $query->where('status', 'completado');

        $query->with(['product_for_transfers', 'companies', 'users']);

        $query->orderBy('updated_at', 'desc');

        return $query->get();
    }

    public function buscarProductos()
    {
        if($this->search != null)
        {
            $transfers = $this->getTransfer();

            $products = [];

            foreach ($transfers as $transfer)
            {
                foreach ($transfer->product_for_transfers as $pro)
                {
                    if(
                        stripos(
                            $pro->product_stocks->product_in_warehouses->products->name, 
                            $this->search) !== false )
                    {
                        $products[] = $pro;
                    }
                }
            }

            $this->products = $products;
        }
        else
        {
            $this->products = $this->queryParaObtenerLosProductos();
        }
        
        $this->emit('refreshComponent');
    }

    /* Calcular total con impuestos y descuentos */
    public function setTotal()
    {
        $total = 0;
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
}

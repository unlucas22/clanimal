<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
// use App\Models\{Product, Client, User, ProductStock};
use App\Models\{Product, Client, User, Transfer, ProductForStore, ProductForTransfer, ProductStock, ProductForSale, PackForSale, Pack};
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

    /* Oferta */
    public $ofertas = [];
    public $ofertas_guardados = [];

    public $listeners = ['agregarProducto', 'retirarProductoParaCompra', 'agregarOferta', 'retirarOfertaParaCompra'];

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

    public function render()
    {
        /* productos guardados para la venta */
        $productos_para_compra = [];

        foreach ($this->productos_guardados as $product)
        {
            $productos_para_compra[] = ProductForSale::with(['product_details'])->where('id', $product)->first();
        }

        /* productos guardados para la venta */
        $ofertas_para_compra = [];

        foreach ($this->ofertas_guardados as $oferta)
        {
            $ofertas_para_compra[] = PackForSale::with('packs')->where('id', $oferta)->first();
        }

        $this->setTotal();

        return view('livewire.dashboard.create.venta.productos', [
            'products' => $this->products,
            'users' => User::get(),
            'productos_para_compra' => $productos_para_compra,
            'ofertas_para_compra' => $ofertas_para_compra,
        ]);
    }

    /**
     * agrega ofertas y productos para la lista de compra
     * */
    public function agregarOferta($item_id, $cantidad)
    {
        $this->ofertas = [];
        $this->products = [];

        try
        {
            $pack_for_sale = PackForSale::create([
                'pack_id' => $item_id,
                'cantidad' => $cantidad
            ]);

            $this->ofertas_guardados[] = $pack_for_sale->id;
            
            $this->emit('refreshComponent');
            $this->setTotal();
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }

    public function agregarProducto($item_id, $cantidad = 1)
    {
        $this->ofertas = [];
        $this->products = [];

        try
        {
            $product_for_sale = ProductForSale::updateOrCreate([
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

    public function getTransfer()
    {
        $query = Transfer::query();

        $query->where('company_id', Auth::user()->company_id);

        $query->where('status', 'completado');

        $query->with(['product_for_transfers', 'companies', 'users']);

        $query->orderBy('updated_at', 'desc');

        return $query->get();
    }

    /**
     * Buscar el cliente registrado por dni
     *  */
    public function searchClient()
    {
        $this->products = [];
        $this->ofertas = [];
        
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

        $this->buscarOfertas();
        
        $this->emit('refreshComponent');
    }

    public function buscarOfertas()
    {   
        if($this->search != null)
        {
            $packs = [];

            $ofertas = Pack::withCount('product_for_packs')->with('product_for_packs')->whereHas('product_for_packs', function ($query) {
                $query->with('products')->whereHas('products', function ($qry) {
                    $qry->where('name', 'like', '%'.$this->search.'%');
                });
            })->orWhere('name', 'like', '%'.$this->search.'%')->get();

            $products = $this->queryParaObtenerLosProductos();

            if(count($products) && count($ofertas))
            {
                foreach ($ofertas as $oferta)
                {
                    $check = 0;
                    
                    foreach($oferta->product_for_packs as $product_for_packs)
                    {
                        foreach ($products as $producto) 
                        {
                            if($producto->stock > 0)
                            {
                                if( $producto->product_stocks->product_in_warehouses->products->name == $product_for_packs->products->name )
                                {
                                    ++$check;
                                }
                            }
                        }
                    }

                    if($oferta->product_for_packs_count == $check)
                    {
                        $packs[] = $oferta;
                    }
                }
            }

            $this->ofertas = $packs;
        }
        else
        {
            $this->ofertas = $this->queryParaObtenerLosOfertas();
        }
        
        $this->emit('refreshComponent');
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

    /**
     * TRAE TODAS LAS OFERTAS PARA LOS PRODUCTOS EN STOCK
     * */
    public function queryParaObtenerLosOfertas()
    {
        $packs = [];

        $ofertas = Pack::withCount('product_for_packs')->with('product_for_packs')->get();

        $products = $this->queryParaObtenerLosProductos();

        if(count($products) && count($ofertas))
        {
            foreach ($ofertas as $oferta)
            {
                $check = 0;
                
                foreach($oferta->product_for_packs as $product_for_packs)
                {
                    foreach ($products as $producto) 
                    {
                        if($producto->stock > 0)
                        {
                            if( $producto->product_stocks->product_in_warehouses->products->name == $product_for_packs->products->name )
                            {
                                ++$check;
                            }
                        }
                    }
                }

                if($oferta->product_for_packs_count == $check)
                {
                    $packs[] = $oferta;
                }
            }
        }

        return $packs;
    }

    /**
     * RETIRAR DE LA LISTA DE COMPRA
     * */
    public function retirarProductoParaCompra($item_id)
    {
        $this->ofertas = [];
        $this->products = [];

        try
        {
            $productos_guardados_copy = $this->productos_guardados;

            foreach ($productos_guardados_copy as $index => $id)
            {
                if($item_id == $id)
                {
                    ProductForSale::where('id', $item_id)->delete();
                    array_splice($this->productos_guardados, $index, 1);
                    break;
                }
            }

            $this->emit('refreshComponent');
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());   
        }
    }

    public function retirarOfertaParaCompra($item_id)
    {
        $this->ofertas = [];
        $this->products = [];

        try
        {
            $ofertas_guardados_copy = $this->ofertas_guardados;

            foreach ($ofertas_guardados_copy as $index => $id)
            {
                if($item_id == $id)
                {
                    PackForSale::where('id', $item_id)->delete();
                    array_splice($this->ofertas_guardados, $index, 1);
                    break;
                }
            }

            $this->emit('refreshComponent');
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());   
        }
    }

    /**
     *  Calcular el TOTAL con impuestos y descuentos 
     * */
    public function setTotal()
    {
        $total = 0;
        $igv = 0;

        foreach ($this->productos_guardados as $product)
        {
            $pfs = ProductForSale::with(['product_details'])->where('id', $product)->first();

            if(!isset($pfs->cantidad))
            {
                continue;
            }

            for ($i=0; $i < $pfs->cantidad; $i++)
            { 
                $total += $pfs->product_details->getPrecioDeOferta() ?? $pfs->product_details->descuento();

                $igv += $pfs->product_details->diferenciaConImpuestos();
            }

        }

        foreach ($this->ofertas_guardados as $oferta)
        {
            $of = PackForSale::with('packs')->where('id', $oferta)->first();

            for ($i=0; $i < $of->cantidad; $i++)
            { 
                $total += $of->packs->precio;
            }
        }

        $this->total = $total;
        $this->igv = $igv;
    }
}

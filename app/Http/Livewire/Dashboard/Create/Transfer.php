<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Product, Company, ProductDetail, ProductForTransfer, ProductStock, ProductInWarehouse};
use Illuminate\Support\Facades\{Log, Auth};
use Carbon\Carbon;
use DB;

/* Salida de productos */
class Transfer extends Component
{
    /* Busqueda */
    public $search;

    public $company_id;
    public $fecha_envio;
    public $transfer_id;

    /* Productos */
    public $products = [];
    public $productos_guardados = [];

    public $listeners = ['agregarProducto', 'retirarProductoParaCompra', 'dateSelected' => 'updateDate'];

    public function mount()
    {
        $this->products = $this->getProducts();
        $this->company_id = (Company::first())->id;
    }

    public function render()
    {
        /* productos guardados para la venta */
        $productos_para_compra = [];

        foreach ($this->productos_guardados as $producto)
        {
            $product_stock = ProductStock::where('id', $producto['id'])->with('product_in_warehouses')->first();
         
            $product_stock->stock = intval($producto['cantidad']);

            $productos_para_compra[] = $product_stock;
        }

        return view('livewire.dashboard.create.transfer', [
            'products' => $this->products,
            'productos_para_compra' => $productos_para_compra,
            'sedes' => Company::get(),
        ]);
    }

    public function submit()
    {
        DB::beginTransaction();

        try
        {
            $fecha = Carbon::parse($this->fecha_envio);

            $transfer = \App\Models\Transfer::create([
                'company_id' => $this->company_id,
                'user_id' => Auth::user()->id,
                'status' => 'en proceso',
                'fecha_envio' => $fecha,
            ]);

            foreach ($this->productos_guardados as $product)
            {
                ProductForTransfer::create([
                    'transfer_id' => $transfer->id,
                    'product_stock_id' => $product['id'],
                    'stock' => $product['cantidad'],
                ]);

                $product_stock = ProductStock::where('id', $product['id'])->first();

                $product_stock->update([
                    'stock' => $product_stock->stock - $product['cantidad'],
                ]);
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Salida de productos registrado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            DB::commit();

            return redirect(route('dashboard.transfers'));
        }
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            Log::info($e->getMessage());

            DB::rollback();    
        }
    }

    /* Agregar al array */
    public function agregarProducto($item_id, $cantidad = 1)
    {
        try
        {
            $product_for_transfer = [
                'id' => $item_id,
                'cantidad' => $cantidad
            ];

            $this->productos_guardados[] = $product_for_transfer;

        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }

    /* Conector */
    public function updatedSearch($value)
    {
        $this->buscarProductos();
    }

    /* se podría reemplazar por un emit desde script */
    public function updateDate($date)
    {
        $this->fecha_envio = $date;
    }

    /* Buscador */
    public function buscarProductos()
    {
        if($this->search != null)
        {
            $product_stocks = ProductStock::where('stock', '>', 0)->whereHas('product_in_warehouses',function($qry) {
                $qry->whereHas('products', function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('palabras_clave', 'like', '%'.$this->search.'%');
                });
            })->with('product_in_warehouses')->get();

            $products = [];

            foreach ($product_stocks as $product_stock)
            {
                $products[] = $product_stock->product_in_warehouses;
            }

            $this->products = $products;
        }
        else
        {
            $this->products = $this->getProducts();
        }
        
        $this->emit('refreshComponent');
    }

    public function retirarProductoParaCompra($item_id)
    {
        try
        {
            foreach ($this->productos_guardados as $index => $producto)
            {
                if($item_id == $producto['id'])
                {
                    array_splice($this->productos_guardados, $index, 1);
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
     * Obtener el stock disponible de cada presentacion
     * */
    public function getProducts()
    {
        try
        {
            $product_stocks = ProductStock::where('stock', '>', 0)->with('product_in_warehouses')->get();

            $products = [];

            foreach ($product_stocks as $product_stock)
            {
                $products[] = $product_stock->product_in_warehouses;
            }

            return $products;
            // return $item;
        }
        catch (\Exception $e)
        {
            Log::info($e);

            ddd($e);
        }
    }
}
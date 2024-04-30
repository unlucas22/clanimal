<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Pack, ProductForPack, Product};
use Illuminate\Support\Facades\{Log, Auth};
use Carbon\Carbon;
use DB;

class Packs extends Component
{
    public $active = true;
    public $name;
    public $fecha_inicio;
    public $fecha_final;
    public $precio_total = 0;

    /* productos del datalist */
    public $products = [];

    /* array tambien */
    public $products_selected = [];

    public $rules = [
        'name' => 'required',
        'precio_total' => 'required',
        'fecha_final' => 'required',
        'fecha_inicio' => 'required',
    ];

    public $listeners = ['pushProducts', 'fechaInicioSelected', 'fechaFinalSelected'];

    public function fechaInicioSelected($value)
    {
        $this->fecha_inicio = $value;
    }

    public function fechaFinalSelected($value)
    {
        $this->fecha_final = $value;
    }

    public function pushProducts($value)
    {
        if($value != null)
        {
            $this->products_selected[] = Product::with(['product_brands', 'product_categories', 'product_details'])->where('name', $value)->first()->toArray();

            $this->emit('refreshComponent');
        }
    }

    public function mount()
    {
        $this->products = Product::where('active', 1)->get()->toArray();
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();

        try
        {
            $pack = Pack::create([
                'active' => $this->active == 'on' ? true : false,
                'name' => $this->name,
                'fecha_inicio' => Carbon::parse($this->fecha_inicio)->toDateString(),
                'fecha_final' => Carbon::parse($this->fecha_final)->toDateString(),
                'precio' => $this->precio_total,
            ]);

            foreach ($this->products_selected as $product)
            {
                ProductForPack::create([
                    'pack_id' => $pack->id,
                    'product_id' => $product['id'],
                ]);
            }

            DB::commit();

            return redirect(route('dashboard.packs'));
        } 
        catch (\Exception $e)
        {   
            DB::rollback();

            Log::error($e);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error:'.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

}

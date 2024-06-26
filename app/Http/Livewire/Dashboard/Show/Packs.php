<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Models\{Pack, ProductForPack, Product};
use Illuminate\Support\Facades\{Log, Auth};
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class Packs extends Component
{
    public $item_id;

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

    public $listeners = ['pushProducts', 'fechaInicioSelected', 'fechaFinalSelected', 'removeProducts'];

    public function mount(Request $req)
    {
        $pack = Pack::with('product_for_packs')->where('id', intval($req->item_id))->firstOrFail();

        foreach ($pack->product_for_packs as $product)
        {
            $this->products_selected[] = Product::with(['product_brands', 'product_categories', 'product_details'])->where('id', $product->product_id)->first()->toArray();
        }

        $this->item_id = $pack->id;

        $this->active = $pack->active;
        $this->name = $pack->name;

        $this->fecha_inicio = $pack->fecha_inicio;
        $this->fecha_final = $pack->fecha_final;
        $this->precio_total = $pack->precio;

        $this->products = Product::where('active', 1)->get()->toArray();
    }

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

    public function removeProducts($value)
    {
        array_splice($this->products_selected, $value, 1);
        $this->emit('refreshComponent');
    }

    public function render()
    {
        return view('livewire.dashboard.create.packs');
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();

        try
        {

            $pack = Pack::where('id', $this->item_id)->first();

            $pack->update([
                'active' => $this->active == 'on' ? true : false,
                'name' => $this->name,
                'fecha_inicio' => Carbon::parse($this->fecha_inicio)->toDateString(),
                'fecha_final' => Carbon::parse($this->fecha_final)->toDateString(),
                'precio' => $this->precio_total,
            ]);

            ProductForPack::where('pack_id', $pack->id)->delete();

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

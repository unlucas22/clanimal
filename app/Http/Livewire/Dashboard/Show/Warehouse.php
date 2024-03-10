<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Warehouse extends Component
{
    public $warehouse_hashid;

    public $listeners = ['refreshParent' => '$refresh'];

    public function mount(Request $req)
    {
        $this->warehouse_hashid = $req->hashid;
    }

    public function render()
    {
        try
        {
            $warehouse = \App\Models\Warehouse::with(['product_in_warehouses', 'suppliers', 'users'])->hashid($this->warehouse_hashid)->firstOrFail();

            $products = [];

            foreach ($warehouse->product_in_warehouses as $product_in_warehouse)
            {
                $products[] = $product_in_warehouse;
            }

            return view('livewire.dashboard.show.warehouse', [
                'warehouse' => $warehouse,
                'products' => $products,
            ]);
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());

            return abort(404);
        }
    }
}

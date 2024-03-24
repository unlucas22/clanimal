<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductStocks extends Component
{
    public $warehouse_hashid;
    
    public function mount(Request $req)
    {
        $this->warehouse_hashid = $req->hashid;
    }

    public function render()
    {
        try
        {
            $item = Product::hashid($this->warehouse_hashid)->whereHas('product_in_warehouses')->with('product_in_warehouses')->first();

            $products = [];

            foreach ($item->product_in_warehouses as $product_in_warehouses)
            {
                $products[] = $product_in_warehouses;
            }

            return view('livewire.dashboard.show.product-stocks', [
                'warehouse' => $item,
                'products' => $products,
            ]);
        }
        catch (\Exception $e)
        {
            Log::info($e);

            abort(404);
        }
    }
}

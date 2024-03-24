<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Transfer extends Component
{
    public $transfer_hashid;

    public $listeners = ['refreshParent' => '$refresh'];

    public function mount(Request $req)
    {
        $this->transfer_hashid = $req->hashid;
    }

    public function render()
    {
        try
        {
            $transfer = \App\Models\Transfer::with(['product_for_transfers', 'companies', 'users'])->hashid($this->transfer_hashid)->firstOrFail();

            $products = [];

            foreach ($transfer->product_for_transfers as $product_in_transfers)
            {
                $products[] = $product_in_transfers;
            }

            return view('livewire.dashboard.show.transfer', [
                'transfer' => $transfer,
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

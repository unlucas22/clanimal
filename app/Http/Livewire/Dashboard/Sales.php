<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{Sale, Bill};

class Sales extends Component
{
    public function render()
    {
        $sales = Sale::with(['presales', 'clients', 'users'])->active()->orderBy('created_at', 'desc')->get();

        $bills = Bill::with(['clients', 'users', 'referentes'])->withCount('product_for_sales')->orderBy('created_at', 'desc')->get();

        return view('livewire.dashboard.sales', [
            'sales' => $sales,
            'notifications' => $bills,
        ]);
    }
}

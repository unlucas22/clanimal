<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{Shift, Sale, Bill};

class Sales extends Component
{
    public function render()
    {
        $sales = Sale::with(['presales', 'clients', 'users'])->where('active', true)->get();

        $notifications = Bill::with(['clients', 'users', 'referentes'])->withCount('product_for_sales')->get();

        return view('livewire.dashboard.sales', [
            'sales' => $sales,
            'notifications' => $notifications,
        ]);
    }
}

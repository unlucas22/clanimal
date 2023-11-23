<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{Shift, Sale};

class Sales extends Component
{
    public function render()
    {
        $sales = Sale::with(['presales', 'clients', 'users'])->where('active', true)->get();

        $notifications = [];

        return view('livewire.dashboard.sales', [
            'sales' => $sales,
            'notifications' => $notifications,
        ]);
    }
}

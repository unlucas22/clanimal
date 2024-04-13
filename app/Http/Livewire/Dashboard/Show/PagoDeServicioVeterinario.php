<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Sale;

class PagoDeServicioVeterinario extends Component
{
    public $item_id;

    public $listeners = ['refreshParent' => '$refresh'];

    public function mount(Request $req)
    {
        $this->item_id = $req->item_id;
    }

    public function render()
    {
        $sale = Sale::with(['clients', 'users', 'presales'])->where('id', $this->item_id)->first();

        return view('livewire.dashboard.show.pago-de-servicio-veterinario', [
            'sale' => $sale
        ]);
    }
}

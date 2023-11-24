<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Shift;
use App\Traits\HasStatus;

class Receptions extends Component
{
    use HasStatus;

    public $title = 'Recepción';

    public function render()
    {
        $shifts = Shift::with(['users', 'pets', 'services'])->whereIn('status', $this->status_lista_de_espera)->orderBy('updated_at', 'desc')->paginate(25);

        $notifications = Shift::with(['users', 'pets', 'services'])->whereIn('status', $this->status_notificaciones)->orderBy('updated_at', 'desc')->paginate(25);

        return view('livewire.dashboard.receptions', [
            'shifts' => $shifts,
            'notifications' => $notifications,
        ]);
    }

    public function marcarComoEntregado($item_id)
    {
        Shift::where('id', $item_id)->update([
            'status' => 'terminado',
        ]);

        $this->emit('refreshComponent');
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Shift;
use App\Traits\HasStatus;

class Receptions extends Component
{
    use HasStatus;

    public $title = 'Recepción';

    public $searchShift = '';

    public $searchNotification = '';

    public function getItemsFromShift()
    {
        $query = Shift::query();

        if($this->searchShift != '')
        {
            $query->whereHas('pets', function($q) {
                $q->where('name', 'like', '%' . $this->searchShift . '%');
            })->orWhere('status', 'like', '%' . $this->searchShift . '%')->orWhere('id', 'like', '%' . $this->searchShift . '%');
        }

        $query->whereIn('status', $this->status_lista_de_espera);

        $query->with(['users', 'pets', 'services']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10, '*', 'paginationShift');
    }

    public function getItemsFromNotification()
    {
        $query = Shift::query();

        if($this->searchNotification != '')
        {
            $query->whereHas('products', function($q){
                $q->where('name', 'like', '%' . $this->searchNotification . '%');
            })->orWhere('fecha', 'like', '%' . $this->searchNotification . '%');
        }

        $query->whereIn('status', $this->status_notificaciones);

        $query->with(['users', 'pets', 'services']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10, '*', 'paginationNotification');
    }

    public function render()
    {
        $shifts = $this->getItemsFromShift();

        $notifications = $this->getItemsFromNotification();

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

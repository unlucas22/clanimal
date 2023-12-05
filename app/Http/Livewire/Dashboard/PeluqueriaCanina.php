<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Shift;

class PeluqueriaCanina extends Component
{
    use HasTable;

    public $title = 'Peluquería Canina';

    public $columns = [
        'id' => 'ID',
        'appointment' => 'Cita',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = Shift::query();

        $query->whereHas('services', function($query) {
            $query->where('name', 'Peluquería Canina');
        });

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('appointment', 'like', '%' . $this->search . '%');
        }

        $query->withCount(['users', 'pets', 'services']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'shifts';

        $this->relationships = [
            'Mascota',
            'Cliente',
            'Tipo de Servicio',
            'Estado',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'peluqueria-canina',
            'head_name' => 'turno',
            'description' => 'Administración de veterinaria'
        ]);
    }
}

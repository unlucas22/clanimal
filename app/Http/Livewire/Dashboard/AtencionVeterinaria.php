<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Shift;

class AtencionVeterinaria extends Component
{
    use HasTable;

    public $title = 'Veterinaria';

    public $columns = [
        'id' => 'ID',
        'appointment' => 'Cita',
    ];

    public $search = '';

    public function getItems()
    {
        $query = Shift::query();

        $query->whereHas('services', function($qry) {
            $qry->where('name', 'Atención Veterinaria');
        });

        if($this->search != '')
        {
            $query->where('appointment', 'like', '%' . $this->search . '%');
        }

        $query->with(['users', 'pets', 'services']);

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
            'action_name' => 'atencion-veterinaria',
            'head_name' => 'turno',
            'description' => 'Administración de veterinaria'
        ]);
    }
}

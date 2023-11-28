<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Shift;

class AtencionVeterinaria extends Component
{
    use HasTable;

    public $title = 'Veterinaria';

    public $filters = [];

    public $columns = [
        'id' => 'ID',
        'appointment' => 'Cita',
    ];

    public function render()
    {
        $items = Shift::with(['users', 'pets', 'services'])->whereHas('services', function($query) {
            $query->where('name', 'Atención Veterinaria');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

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
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'atencion-veterinaria',
            'head_name' => 'turno',
            'description' => 'Administración de veterinaria'
        ]);
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Shift;

class Shifts extends Component
{
    use HasTable;

    public $title = 'Turnos';

    public $filters = [];

    public $columns = [
        'appointment' => 'Cita',
        'status' => 'Estado',
    ];

    public function render()
    {
        $items = Shift::with(['users', 'pets', 'services'])->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'shifts';

        $this->relationships = [
            'Creado Por',
            'Mascota',
            'Cliente',
            'Tipo de Servicio',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'sede',
            'head_name' => 'turno',
        ]);
    }
}

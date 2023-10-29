<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Reception;

class Receptions extends Component
{
    use HasTable;

    public $title = 'Recepción';

    public $filters = [];

    public $columns = [
        'entry' => 'Ingreso',
        'delivery' => 'Salida',
    ];

    public function render()
    {
        $items = Reception::with(['users', 'pets', 'services', 'shifts'])->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'receptions';

        $this->relationships = [
            'Creado Por',
            'Mascota',
            'Cliente',
            'Tipo de Servicio',
            'Turno',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'sede',
            'head_name' => 'reception',
        ]);
    }
}

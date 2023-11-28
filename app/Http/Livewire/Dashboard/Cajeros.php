<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Casher;

class Cajeros extends Component
{
    use HasTable;

    public $title = 'Configuración Cajas';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre Caja',
        'formatted_active' => 'Estado',
    ];

    public $name = '';

    public function render()
    {
        $items = Casher::with(['users', 'companies'])->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'cashers';

        $this->relationships = [
            'Cajera ',
            'Local ',
        ];

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'cajeros',
            'head_name' => 'cajeros',
        ]);
    }

    /*
public $filters = [
    'name' => '',
];

public $columns = [
    'id' => 'ID',
    'status' => 'Estado',
    'amount' => 'Monto en caja',
    'closed_at' => 'Cerrado',
    'created_at' => 'Abierto',
];

public $name = '';

public function render()
{
    $items = CashRegister::with(['users', 'operations'])->when($this->name !== '', function($qry) {
        $qry->where('name', 'like', '%'.$this->name.'%');
    })->orderBy('updated_at', 'desc')->paginate($this->rows);

    $this->table = 'cash_registers';

    $this->relationships = [
        // 'Cajera ',
        // 'Efectivo ',
        // 'Tarjeta ',
        // 'Tarjeta Virtual ',
    ];

    $this->can_delete = false;

    $this->created_at = false;
    $this->updated_at = false;

    return view('livewire.dashboard.table', [
        'items' => $items,
        'rows_count' => $this->rows_count,
        'columns' => $this->columns,
        'columns_count' => $this->getColumnsCount($this->columns),
        // 'action_name' => 'client',
        'head_name' => 'cajeros',
    ]);
}

    */
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;

class Suppliers extends Component
{
    use HasTable;

    public $title = 'Proveedores';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre',
        'ruc' => 'RUC',
        'address' => 'Dirección',
        'phone' => 'Contacto',
    ];

    public $name = '';

    public function render()
    {
        $items = \App\Models\Supplier::when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'suppliers';

        $this->relationships = [
            //'Total Productos',
        ];

        $this->relationship_name = 'suppliers';

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'supplier',
            'head_name' => 'supplier',
        ]);
    }
}

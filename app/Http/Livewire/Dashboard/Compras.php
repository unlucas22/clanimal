<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Warehouse;

class Compras extends Component
{
    use HasTable;

    public $title = 'Compras';

    public $filters = [
        'name' => '',
    ];
    public $name = '';

    public $columns = [
        'id' => 'ID',
        'fecha' => 'Fecha de recepción',
        'factura' => 'Factura',
        'total' => 'Monto Total',
        'status' => 'Estado'
    ];

    public function render()
    {
        $items = Warehouse::with(['products', 'companies', 'suppliers'])->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'warehouses';

        $this->relationships = [
            'Proveedor ',
            'Local',
            'Producto',
        ];

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'warehouse',
            'head_name' => 'warehouse',
        ]);
    }
}

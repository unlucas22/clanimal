<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Warehouse;

class Compras extends Component
{
    use HasTable;

    public $title = 'Compras';

    public $search = '';

    public $columns = [
        'id' => 'ID',
        'fecha' => 'Fecha de recepción',
        'factura' => 'Factura',
        'total' => 'Monto Total',
        'status' => 'Estado'
    ];

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = Warehouse::query();

        if($this->search != '')
        {
            $query->where('factura', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%');
        }

        $query->with('suppliers');

        $query->withCount('product_in_warehouses');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'warehouses';

        $this->relationships = [
            'Proveedor',
            'Productos',
        ];

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'warehouse',
            'head_name' => 'warehouse',
        ]);
    }
}

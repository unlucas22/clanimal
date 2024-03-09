<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Warehouse;

class FinanzasFacturas extends Component
{
    use HasTable;

    public $title = 'Facturas';

    public $description = 'Pago de Facturas';

    public $search = '';

    public $columns = [
        'id' => 'ID',
        'fecha' => 'Fecha',
        'key_type' => 'Tipo',
        'value_type' => '',
        'monto_formatted' => 'Monto Total',
        'status_formatted' => 'Estado'
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
            'RUC',
        ];

        $this->relationship_name = 'finanzas-facturas';

        $this->updated_at = false;
        $this->created_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'finanzas-facturas',
        ]);
    }
}

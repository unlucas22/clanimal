<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{Warehouse, WarehousePayment, WarehouseFeePayment};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use App\Traits\HasTable;

class CuentasPorPagar extends Component
{
    use HasTable;

    public $title = 'Cuentas Por Pagar';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];
    public $search = '';

    public function getItems()
    {
        $query = WarehousePayment::query();

        $query->with(['warehouses']);
        $query->withCount('warehouse_fee_payments');

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'warehouse_payments';

        $this->relationships = [
            'Fecha',
            'Factura',
            'Proveedor',
            'Monto total',
            'Monto Pagado',
            'Monto Restante',
            'Cantidad de Cuotas',
            'Cuotas Pagadas',
            'Estado',
        ];

        $this->updated_at = false;
        $this->created_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'cuentas-por-pagar',
            // 'head_name' => 'cajeros',
        ]);
    }
}

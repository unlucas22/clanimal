<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{CashRegister, User, Casher, Finance};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use App\Traits\HasTable;

class IngresosGerencia extends Component
{
    use HasTable;

    public $title = 'Ingresos';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];
    public $search = '';

    public function getItems()
    {
        $query = CashRegister::query();

        if($this->search != '')
        {
            $query->where('status', 'like', '%' . $this->search . '%')
                ->orWhere('validated_at', 'like', '%' . $this->search . '%');
        }

        $query->with('cashers');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'casher_registers';

        $this->relationships = [
            'Fecha solicitud',
            'Fecha de validación',
            'Caja',
            'Cajera',
            'Monto Tarjeta',
            'Monto Tarjeta Virtual',
            'Monto Efectivo',
            'En caja',
            'Estado'
        ];

        $this->updated_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'casher_registers',
            // 'head_name' => 'cajeros',
        ]);
    }
}

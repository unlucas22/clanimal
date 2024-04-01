<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{CashRegister, User, Casher, Finance};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use App\Traits\HasTable;

class SalidasGerencia extends Component
{
    use HasTable;

    public $title = 'Salidas';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];
    public $search = '';

    public function getItems()
    {
        $query = Finance::query();

        if($this->search != '')
        {
            $query->where('status', 'like', '%' . $this->search . '%')
                ->orWhere('reported_at', 'like', '%' . $this->search . '%');
        }

        $query->with('users');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'finances';

        $this->relationships = [
            'Fecha de reporte', 'Gerente de Tienda', 'Local', ' Monto Tarjeta', 'Monto Efectivo', 'Estado'
        ];

        $this->updated_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'finances',
            'head_name' => 'finances',
        ]);
    }
}

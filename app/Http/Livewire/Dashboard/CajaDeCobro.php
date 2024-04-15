<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use App\Traits\HasTable;

class CajaDeCobro extends Component
{
    use HasTable;

    public $title = 'Cuentas Por Cobrar';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];
    public $search = '';

    public function getItems()
    {
        $query = Client::query();

        $query->withCount('client_payments');

        $query->where(function($q) {
            $q->where('credito_actual', '>', 0)
              ->orWhere(function($query) {
                $query->has('client_payments');
            });
        });

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'clients';

        $this->relationships = [
            'Fecha',
            'Cliente',
            'Monto de Crédito',
            'Monto Deuda',
            'Estado',
        ];

        $this->updated_at = false;
        $this->created_at = false;
        $this->can_delete = false;
        $this->relationship_name = 'cuentas-por-cobrar';

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'caja-de-cobro',
            // 'head_name' => 'cajeros',
        ]);
    }
}

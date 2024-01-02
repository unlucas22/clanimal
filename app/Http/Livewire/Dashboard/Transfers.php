<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Transfer;

class Transfers extends Component
{
     use HasTable;

    public $title = 'Salida de Productos';

    public $columns = [
        'id' => 'ID',
        'fecha_envio_formatted' => 'Fecha de Envío',
        'fecha_recepcion_formatted' => 'Fecha de Recepción',
        'status_formatted' => 'Estado',
    ];
    
    public $listeners = ['refreshParent' => '$refresh'];

    public $search = '';

    public function getItems()
    {
        $query = Transfer::query();

        if($this->search != '')
        {
            $query->where('fecha_envio', 'like', '%' . $this->search . '%')
                ->orWhere('fecha_recepcion', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        }

        $query->with(['companies', 'product_for_transfers']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'transfers';

        $this->relationships = [
            'Destino Sede',
            'Total Productos',
        ];

        $this->created_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'transfer',
            'head_name' => 'transfer',
        ]);
    }
}

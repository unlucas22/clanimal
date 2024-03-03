<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;

class Suppliers extends Component
{
    use HasTable;

    public $title = 'Proveedores';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre',
        'ruc' => 'RUC',
        'address' => 'Dirección',
        'phone' => 'Contacto',
    ];

    public $listeners = ['refreshParent' => '$refresh'];

    public $search = '';

    public function getItems()
    {
        $query = \App\Models\Supplier::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('ruc', 'like', '%' . $this->search . '%')
                ->orWhere('address', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'suppliers';

        $this->relationships = [
            //'Total Productos',
        ];

        $this->relationship_name = 'suppliers';

        $this->created_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'supplier',
            'head_name' => 'supplier',
        ]);
    }
}

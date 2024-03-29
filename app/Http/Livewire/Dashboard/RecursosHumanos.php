<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Manpower;

class RecursosHumanos extends Component
{
    use HasTable;

    public $title = 'Recursos Humanos';

    public $columns = [
        'id' => 'ID',
    ];

    public $listeners = ['refreshParent' => '$refresh'];

    public $search = '';

    public function eliminar($item_id)
    {
        ProductDetail::where('product_id', $item_id)->delete();
        Product::where('id', $item_id)->delete();
    }

    public function getItems()
    {
        $query = Manpower::query();
        
        $query->with(['users', 'payment_methods']);

        $query->whereHas('users', function($qry){
            $qry->when($this->search !== '', function($filter) {
                $filter->where('users.name', 'like', '%'.$this->search.'%')
                ->orWhere('users.cedula', 'like', '%'.$this->search.'%')
                ->orWhere('users.email', 'like', '%'.$this->search.'%');
            });
        });

        /*
        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%');
        }
        */
        
        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'manpowers';

        $this->relationships = [
            'Nombre completo',
            'DNI',
            'Dirección',
            'Email',
            'Télefono',
            'Cargo',
            'Fecha de contratación',
            'Sueldo',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            //'action_name' => 'manpower',
            'head_name' => 'manpower',
        ]);
    }
}

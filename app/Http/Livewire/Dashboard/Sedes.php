<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Company, User};

class Sedes extends Component
{
    use HasTable;

    public $title = 'Sedes';

    public $columns = [
        'name' => 'Titulo',
        'address' => 'Dirección',
        'email' => 'Correo electronico',
        'phone' => 'Telefono',
    ];

    public $search = '';

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];

    /**
     *  ¡para un futuro: asignar a otra sede los colaboradores y productos!
     * */
    public function delete($item_id)
    {
        $this->deleteItem($item_id);
    }

    public function getItems()
    {
        $query = Company::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('address', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        }

        $query->withCount('users');

        $query->orderBy('created_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'companies';

        $this->relationships = [
            'Trabajadores en la Sede',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'sede',
            'head_name' => 'sede',
        ]);
    }
}

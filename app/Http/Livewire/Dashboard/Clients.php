<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Client;

class Clients extends Component
{
    use HasTable;

    public $title = 'Clientes';

    public $listeners = ['refreshParent' => '$refresh'];
    public $search = '';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombres y Apellidos',
        'dni' => 'DNI',
        'address' => 'Dirección'
    ];

    public function getItems()
    {
        $query = Client::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        }

        $query->with(['users', 'reports']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'clients';

        $this->relationships = [
            'Calificación',
        ];

        $this->can_delete = false;

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'client',
            'head_name' => 'client',
        ]);
    }
}

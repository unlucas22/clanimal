<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Report;
use App\Traits\HasTable;

class Classifications extends Component
{
    use HasTable;

    public $title = 'Clasificación de clientes';

    public $columns = [
        'key' => 'Nombre',
        'name' => 'Titulo especial',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];

    public function delete($item_id)
    {
        $this->deleteItem($item_id);
    }

    public $search = '';

    public function getItems()
    {
        $query = Report::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('key', 'like', '%' . $this->search . '%');
        }

        $query->withCount('clients');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'reports';

        $this->relationships = [
            'Contador de Clientes',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'classification',
            'head_name' => 'classification',
        ]);
    }
}

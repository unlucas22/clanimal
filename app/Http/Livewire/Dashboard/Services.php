<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Service;

class Services extends Component
{
    use HasTable;

    public $title = 'Servicios';

    public $columns = [
        'name' => 'Titulo',
        'description' => 'Descripción'
    ];

    public $search = '';

    protected $listeners = ['deleteItem' => 'delete'];

    public function delete($item_id)
    {
        $this->deleteItem($item_id);
    }

    public function getItems()
    {
        $query = Service::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $query->withCount(['shifts']);

        $query->orderBy('shifts_count', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'services';

        $this->relationships = [
            'Turnos',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'user',
            'head_name' => 'service',
        ]);
    }
}

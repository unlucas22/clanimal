<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Casher;

class Cajeros extends Component
{
    use HasTable;

    public $title = 'Cajas';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre Caja',
        'formatted_active' => 'Estado',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];
    public $search = '';

    public function delete($item_id)
    {
        $this->deleteItem($item_id);
    }


    public function getItems()
    {
        $query = Casher::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $query->with(['users', 'companies']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'cashers';

        $this->relationships = [
            'Cajera ',
            'Local ',
        ];

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'cajeros',
            'head_name' => 'cajeros',
        ]);
    }
}

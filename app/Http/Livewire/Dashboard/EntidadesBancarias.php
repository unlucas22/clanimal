<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PaymentMethod;
use App\Traits\HasTable;

class EntidadesBancarias extends Component
{
    use HasTable;

    public $title = 'Entidades Bancarias';

    public $columns = [
        'id' => 'ID',
        'name' => 'Titulo',
    ];
    
    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];

    public $search = '';

    public function delete($item_id)
    {
        $this->deleteItem($item_id);
    }

    public function getItems()
    {
        $query = PaymentMethod::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $query->withCount('manpowers');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'payment_methods';

        $this->relationships = [
            'Colaboradores con el Metodo',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'payment_method',
            'head_name' => 'payment_method',
        ]);
    }

}

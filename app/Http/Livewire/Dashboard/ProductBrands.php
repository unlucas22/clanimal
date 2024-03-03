<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;

class ProductBrands extends Component
{
    use HasTable;

    public $title = 'Marcas';

    public $columns = [
        'id' => 'ID',
        'name' => 'Titulo',
        'description' => 'Descripción',
        'formatted_active' => 'Estado',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];
    public $search = '';

    public function delete($item_id)
    {
        $this->deleteItem($item_id);

        $this->emit('refreshComponent');
    }

    public function getItems()
    {
        $query = \App\Models\ProductBrand::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        }

        $query->withCount('products');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'product_brands';

        $this->relationships = [
            'Total Productos',
        ];

        $this->relationship_name = 'product-details';

        $this->created_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'product-brand',
            'head_name' => 'product-brand',
        ]);
    }
}

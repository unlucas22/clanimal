<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;

class ProductCategories extends Component
{
    use HasTable;

    public $title = 'Categorías';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Titulo',
        'description' => 'Descripción',
        'formatted_active' => 'Estado',
    ];

    protected $listeners = ['deleteItem' => 'delete'];

    public function delete($item_id)
    {
        $this->deleteItem($item_id);

        $this->emit('refreshComponent');
    }

    public $name = '';

    public function render()
    {
        $items = \App\Models\ProductCategory::withCount('products')->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'product_categories';

        $this->relationships = [
            'Total Productos',
        ];

        $this->relationship_name = 'product-details';

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'product-category',
            'head_name' => 'product-category',
        ]);
    }
}

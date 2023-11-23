<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;

class ProductPresentations extends Component
{
    use HasTable;

    public $title = 'Tipo de Presentación';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Titulo',
        'description' => 'Descripción',
        'formatted_active' => 'Estado',
    ];

    public $name = '';

    public function render()
    {
        $items = \App\Models\ProductPresentation::withCount('products')->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'product_presentations';

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
            'action_name' => 'product-presentation',
            'head_name' => 'product-presentation',
        ]);
    }
}

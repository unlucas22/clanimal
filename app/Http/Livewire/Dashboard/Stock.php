<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{ProductStock, Warehouse, Product};
use Illuminate\Support\Facades\{Auth, Log};
use DB;

/**
 * Lotes
 * */
class Stock extends Component
{
    use HasTable;

    public $title = 'Stock';

    public $columns = [
        'id' => 'ID',
    ];

    public $search = '';

    protected $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = Product::query();

        $query->whereHas('product_in_warehouses');

        $query->with('product_in_warehouses');

        $query->withCount('product_in_warehouses');

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'product_stocks';

        $this->relationships = [
            'Producto',
            'Cantidad de Lotes',
            'Stock total',
            'Fecha de Compra',
            'Fecha de primer Vencimiento',
        ];

        $this->created_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'product_stocks',
            // 'head_name' => 'sede',
        ]);
    }
}

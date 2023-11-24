<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Product, ProductDetail};

class Products extends Component
{
    use HasTable;

    public $title = 'Productos';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
    ];

    /* eliminar */
    public function eliminar($item_id)
    {
        ProductDetail::where('product_id', $item_id)->delete();
        Product::where('id', $item_id)->delete();
    }

    public $name;

    public function render()
    {
        $items = Product::with(['product_brands', 'product_categories'])->orderBy('updated_at', 'desc')->get();

        $this->table = 'products';

        $this->relationships = [
            'Imagen',
            'Categoría',
            'Marca',
            'Producto',
            'Stock',
            'Precio Compra',
            'Precio Venta (IGV)',
            'Ganancia',
        ];

        $this->created_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'product',
            'head_name' => 'product',
        ]);
    }
}

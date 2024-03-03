<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Product, ProductDetail, ProductInWarehouse};

class Products extends Component
{
    use HasTable;

    public $title = 'Productos';

    public $columns = [
        'id' => 'ID',
    ];

    public $listeners = ['deleteItem' => 'eliminar', 'refreshParent' => '$refresh', 'activeItem' => 'activar'];

    public $search = '';

    public function eliminar($item_id)
    {
        Product::where('id', $item_id)->update([
            'active' => false
        ]);
    }

    public function activar($item_id)
    {
        Product::where('id', $item_id)->update([
            'active' => true
        ]);
    }

    public function getItems()
    {
        $query = Product::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('palabras_clave', 'like', '%' . $this->search . '%')
                ->orWhere('barcode', 'like', '%' . $this->search . '%');
        }

        $query->with(['product_brands', 'product_categories']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'products';

        $this->relationships = [
            'Imagen',
            'Categoría',
            'Marca',
            'Producto',
            'Ganancia',
            'Stock',
            'Precio Compra',
            'Precio Venta (IGV)',
            'Estado',
        ];

        $this->created_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'product',
            'head_name' => 'product',
        ]);
    }
}

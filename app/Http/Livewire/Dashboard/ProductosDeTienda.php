<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Product, ProductDetail, ProductInWarehouse, Transfer, ProductForTransfer};
use Illuminate\Support\Facades\{Auth, Log};

class ProductosDeTienda extends Component
{
    use HasTable;

    public $title = 'Productos De Tienda';

    public $columns = [
        'id' => 'ID',
    ];

    public $listeners = [
        'refreshParent' => '$refresh', 
    ];

    public $search = '';

    public function getItems()
    {
        $query = Transfer::query();

        $query->where('company_id', Auth::user()->company_id);

        $query->where('status', 'completado');

        $query->with(['product_for_transfers', 'companies', 'users']);

        $query->withCount('product_for_transfers');

        $query->orderBy('updated_at', 'desc');


        $transfers = $query->get();

        $products = [];

        foreach ($transfers as $transfer)
        {
            foreach ($transfer->product_for_transfers as $pro)
            {
                $products[] = $pro->product_stocks->product_in_warehouses->products;
            }
        }

        $products_to_search = collect($products)->pluck('id')->unique();

        $query = Product::query();

        $query->whereIn('id', $products_to_search);

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
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->can_delete = false;
        $this->relationship_name = 'productos-de-tienda';

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'product',
            // 'head_name' => 'product',
        ]);
    }
}

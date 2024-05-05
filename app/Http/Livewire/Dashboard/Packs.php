<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Pack;

class Packs extends Component
{
    use HasTable;

    public $title = 'Administración de Ofertas';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre de Oferta',
    ];

    public $search = '';

    public function getItems()
    {
        $query = Pack::query();

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%');
        }

        $query->with('product_for_packs');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'packs';

        $this->relationships = [
            'Descripción',
            'Fecha de Inicio',
            'Fecha final',
            'Precio Total',
        ];

        $this->updated_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'packs',
            'head_name' => 'packs',
        ]);
    }
}

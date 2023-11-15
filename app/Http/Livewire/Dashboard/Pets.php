<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Pet;

class Pets extends Component
{
    use HasTable;

    public $title = 'Mascotas';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Mascota',
        'age' => 'Edad',
        'gender' => 'Sexo',
        'height' => 'Talla',
    ];

    public $name = '';

    public function render()
    {
        $items = Pet::with(['clients', 'type_of_pets'])->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('created_at', 'desc')->paginate($this->rows);

        $this->table = 'pets';

        $this->relationships = [
            'Especie',
            'Cliente',
            'DNI',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'pet',
            'head_name' => 'pet',
        ]);
    }
}

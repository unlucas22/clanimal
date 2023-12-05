<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Pet;

class Pets extends Component
{
    use HasTable;

    public $title = 'Mascotas';

    public $columns = [
        'id' => 'ID',
        'name' => 'Mascota',
        'age' => 'Edad',
        'gender' => 'Sexo',
        'height' => 'Talla',
    ];

    public $listeners = ['refreshParent' => '$refresh'];

    public $search = '';

    public function getItems()
    {
        $query = Pet::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('age', 'like', '%' . $this->search . '%')
                ->orWhere('gender', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        }

        $query->withCount(['clients', 'type_of_pets']);

        $query->orderBy('created_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'pets';

        $this->relationships = [
            'Especie',
            'Cliente',
            'DNI',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'pet',
            'head_name' => 'pet',
        ]);
    }
}

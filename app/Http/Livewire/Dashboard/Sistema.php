<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Setting;

class Sistema extends Component
{
    use HasTable;

    public $title = 'Configuración';

    public $description = 'El "Tipo de Valor" es referencial, no excluyente. <span style="color:red; margin-left:5px;">Modificar con precaución</span>.';

    public $columns = [
        'id' => 'ID',
        'key' => 'Clave',
        'description' => 'Descripción',
        'type_formatted' => 'Tipo de Valor',
        'value_formatted' => 'Valor',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = Setting::query();

        if($this->search != '')
        {
            $query->where('key', 'like', '%' . $this->search . '%')
                ->orWhere('value', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'setting';

        $this->relationships = [
        ];

        $this->can_delete = false;

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'setting',
            'head_name' => 'setting',
        ]);
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{User, Control};

class Controls extends Component
{
    use HasTable;

    public $title = 'Registro de Control de colaboradores';

    public $columns = [
        'id' => 'ID',
        'ip' => 'Dirección IP',
        'date' => 'Fecha y Hora',
        'device' => 'Dispositivo (User Agent)',
    ];

    public $search = '';

    public function getItems()
    {
        $query = Control::query();

        $query->whereHas('users', function($qry){
            $qry->when($this->search !== '', function($filter) {
                $filter->where('users.name', 'like', '%'.$this->search.'%');
            });
        });

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('ip', 'like', '%' . $this->search . '%');
        }

        $query->withCount(['users', 'reasons']);

        $query->orderBy('created_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'controls';

        $this->updated_at = false;
        $this->created_at = false;

        $this->relationships = [
            'Trabajador',
            'Acceso',
            'Motivo',
        ];

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'control',
            'head_name' => 'control',
        ]);
    }
}

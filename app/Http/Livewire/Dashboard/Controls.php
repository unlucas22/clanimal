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

    public $filters = [];

    public $input = '';

    public function render()
    {
        $items = Control::with(['users', 'reasons'])->whereHas('users', function($qry){
            $qry->when($this->input !== '', function($filter) {
                $filter->where('users.name', 'like', '%'.$this->input.'%');
            });
        })/*->when($this->input !== '', function($qry) {
            $qry->where('ip', 'like', '%'.$this->input.'%')->orWhere('created_at', 'like', '%'.$this->input.'%');
        })*/->orderBy('created_at', 'desc')->paginate($this->rows);

        $this->table = 'controls';

        $this->updated_at = false;
        $this->created_at = false;

        $this->relationships = [
            'Trabajador',
            'Acceso',
            'Motivo',
        ];

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'control',
            'head_name' => 'control',
        ]);
    }
}

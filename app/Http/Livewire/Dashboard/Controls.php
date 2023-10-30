<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{User, Control};

class Controls extends Component
{
    use HasTable;

    public $title = 'Control de trabajadores por QR';

    public $columns = [
        'id' => 'ID',
        'ip' => 'Dirección IP',
        'hostname' => 'Servicio de host',
        'device' => 'Dispositivo',
        'city' => 'Ciudad',
    ];

    public $filters = [];

    public $name;

    public function render()
    {
        $items = Control::with('users')->whereHas('users', function($qry){
            $qry->when($this->name !== '', function($filter) {
                $filter->where('users.name', 'like', '%'.$this->name.'%');
            });
        })->orderBy('created_at', 'desc')->paginate($this->rows);

        $this->table = 'controls';

        $this->relationships = [
            'Trabajador',
            'Acceso',
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

    /* actions */
    public function updateConfirmed(int $item_id)
    {
        Control::where('id', $item_id)->update([
            'confirmed' => true,
        ]);
    }
}

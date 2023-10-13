<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{User, Control};

class Controls extends Component
{
    use HasTable;

    public $title = 'Control de usuarios por QR';

    public $filters = [
        'device' => 'Dispositivo',
    ];

    public $columns = [
        'ip' => 'Dirección IP',
        'hostname' => 'Servicio de host',
        'device' => 'Dispositivo',
        'city' => 'Ciudad',
        'confirmed' => 'Confirmado',
    ];

    public $device = '';

    public function render()
    {
        $items = Control::with('users')->when($this->device !== '', function($qry) {
            $qry->where('device', 'like', '%'.$this->device.'%');
        })->orderBy('created_at', 'desc')->paginate($this->rows);

        $this->table = 'controls';

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'user',
            // 'head_name' => 'user',
        ]);
    }
}

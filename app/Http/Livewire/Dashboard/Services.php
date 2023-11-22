<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Service;

class Services extends Component
{
    use HasTable;

    public $title = 'Servicios';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'name' => 'Titulo',
        'description' => 'Descripción'
    ];

    public $name = '';

    public function render()
    {
        $items = Service::withCount(['shifts'])->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('shifts_count', 'desc')->paginate($this->rows);

        $this->table = 'services';

        $this->relationships = [
            'Turnos',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'user',
            'head_name' => 'service',
        ]);
    }
}

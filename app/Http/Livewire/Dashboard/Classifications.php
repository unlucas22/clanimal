<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Report;
use App\Traits\HasTable;

class Classifications extends Component
{
    use HasTable;

    public $title = 'Clasificación de clientes';

    public $filters = [
        'key' => 'titulo',
    ];

    public $columns = [
        'key' => 'Nombre',
        'name' => 'Titulo especial',
    ];

    public $key = '';

    public function render()
    {
        $items = Report::withCount('clients')->when($this->key !== '', function($qry) {
            $qry->where('key', 'like', '%'.$this->key.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'reports';

        $this->relationships = [
            'Contador de Clientes',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'classification',
            'head_name' => 'classification',
        ]);
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Company, User};

class Sedes extends Component
{
    use HasTable;

    public $title = 'Sedes';

    public $filters = [
        'name' => 'nombre',
        'address' => 'dirección',
    ];

    public $columns = [
        'name' => 'Titulo',
        'address' => 'Dirección',
        'email' => 'Correo electronico',
        'phone' => 'Telefono',
    ];

    public $name = '';
    public $address = '';
    public $email = '';
    public $phone = '';

    public function render()
    {
        $items = Company::withCount('users')->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('users_count', 'desc')->paginate($this->rows);

        $this->table = 'companies';

        $this->relationships = [
            'Trabajadores en la Sede',
        ];

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'sede',
            'head_name' => 'sede',
        ]);
    }
}

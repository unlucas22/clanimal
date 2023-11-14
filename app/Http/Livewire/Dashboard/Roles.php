<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Role, Permission};

class Roles extends Component
{
    use HasTable;

    public $title = 'Roles y Permisos';

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
        $items = Role::with('permissions')->withCount('users')->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->orderBy('users_count', 'desc')->paginate($this->rows);

        $this->table = 'roles';

        $this->relationships = [
            'Accesos',
            'Descripción de los permisos',
            'Usuarios con el Rol',
        ];

        $this->created_at = false;
        $this->updated_at = false;

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

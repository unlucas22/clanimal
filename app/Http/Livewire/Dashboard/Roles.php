<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Role, Permission, PermissionForRole, User};

class Roles extends Component
{
    use HasTable;

    public $title = 'Roles y Permisos';

    public $columns = [
        'name' => 'Titulo',
        'description' => 'Descripción'
    ];

    protected $listeners = ['deleteItem' => 'delete'];

    public function delete($item_id)
    {
        PermissionForRole::where('role_id', $item_id)->delete();

        User::where('role_id', $item_id)->update([
            'role_id' => (Role::where('name', 'default')->first())->id,
        ]);

        $this->deleteItem($item_id);
    }

    public $search = '';

    public function getItems()
    {
        $query = Role::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $query->with('permission_for_roles');

        $query->withCount('users');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'roles';

        $this->relationships = [
            'Accesos',
            'Usuarios con el Rol',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'roles',
            // 'head_name' => 'user',
        ]);
    }

}

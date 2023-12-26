<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Role, PermissionForRole, User};

class Puestos extends Component
{
    use HasTable;

    public $title = 'Puestos y Sueldos';

    public $columns = [
        'name' => 'Puesto',
        'description' => 'Descripción',
        'sueldo' => 'Sueldo',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];

    public $search = '';

    public function delete($item_id)
    {
        PermissionForRole::where('role_id', $item_id)->delete();

        User::where('role_id', $item_id)->update([
            'role_id' => (Role::where('name', 'default')->first())->id,
        ]);

        $this->deleteItem($item_id);
    }

    public function getItems()
    {
        $query = Role::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        //$query->with('permission_for_roles');

        $query->where('name', '!=', 'Administrador');

        $query->where('name', '!=', 'Default');

        $query->withCount('users');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'roles';

        $this->relationships = [
            'Usuarios con el Puesto',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->relationship_name = 'puestos';

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'puesto',
            'head_name' => 'puesto',
        ]);
    }

}

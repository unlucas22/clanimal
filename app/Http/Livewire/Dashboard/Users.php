<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\User;

class Users extends Component
{
    use HasTable;

    public $title = 'Usuarios';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre',
        'email' => 'Email',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = User::query();

        if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $query->with(['companies', 'roles']);

        $query->withCount('histories');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'users';

        $this->relationships = [
            'Rol',
            'Sede',
            'Estado',
        ];

        $this->canActive = true;

        $this->created_at = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'user',
            'head_name' => 'user',
        ]);
    }

    /* actions */
    public function updateVerifiedAt(int $item_id)
    {
        User::where('id', $item_id)->update([
            'email_verified_at' => now(),
            'deleted_at' => null,
        ]);
    }
}

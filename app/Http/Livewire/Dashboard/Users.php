<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\User;

class Users extends Component
{
    use HasTable;

    public $title = 'Usuarios';

    public $filters = [
        'input' => '',
    ];

    public $columns = [
        'name' => 'Nombre',
        'email' => 'Email',
    ];

    public $input = '';

    public function render()
    {
        $users = User::withCount('histories')->with(['companies', 'roles'])->when($this->input !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->input.'%');
        })->when($this->input !== '', function($qry) {
            $qry->where('email', 'like', '%'.$this->input.'%');
        })->orderBy('updated_at', 'desc')->withTrashed()->paginate($this->rows);

        $this->table = 'users';

        $this->relationships = [
            'Rol',
            'Sede',
        ];

        $this->canActive = true;

        return view('livewire.dashboard.table', [
            'items' => $users,
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

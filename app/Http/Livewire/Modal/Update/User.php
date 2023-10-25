<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Role, Company};

class User extends ModalComponent
{
    public $item_id;

    public $name;
    public $email;

    public $role_id;
    public $company_id;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'email' => 'required|email|min:3|max:100',
    ];

    public function mount()
    {
        $item = \App\Models\User::where('id', $this->item_id)->firstOrFail();

        $this->name = $item->name;
        $this->email = $item->email;
        $this->role_id = $item->role_id;
        $this->company_id = $item->company_id;
    }

    public function render()
    {
        return view('livewire.modal.update.user', [
            'roles' => Role::get(),
            'companies' => Company::get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        \App\Models\User::where('id', $this->item_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'company_id' => $this->company_id,
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Datos actualizados',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
    }

    public function updatedRoleId()
    {
        \App\Models\User::where('id', $this->item_id)->update([
            'role_id' => $this->role_id
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Rol actualizado',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
    }
}

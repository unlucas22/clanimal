<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\Role;
use Illuminate\Support\Facades\{Hash, Log};

class User extends ModalComponent
{
    public $name;
    public $email;
    public $password;

    public $role_id;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'email' => 'required|email|min:3|max:100',
        'role_id' => 'required',
        'password' => 'required|min:1',
    ];

    public function render()
    {
        return view('livewire.modal.store.user', [
            'roles' => Role::get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        try {

            \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role_id,
                'password' => Hash::make($this->password),
                'verified_at' => now(),
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Usuario creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            return redirect(route('dashboard.users'));
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

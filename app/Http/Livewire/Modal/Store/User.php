<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Role, Company};
use Illuminate\Support\Facades\{Hash, Log};

class User extends ModalComponent
{
    public $name;
    public $email;
    public $dni;
    public $password;

    public $role_id;
    public $company_id;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'email' => 'required|email|min:3|max:100',
        'role_id' => 'required',
        'dni' => 'required',
        'company_id' => 'required',
        'password' => 'required|min:1',
    ];

    public function mount()
    {
        $this->role_id = (Role::first())->id;
        $this->company_id = (Company::first())->id;
    }

    public function render()
    {
        return view('livewire.modal.store.user', [
            'roles' => Role::get(),
            'sedes' => Company::get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        try {

            \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'cedula' => $this->dni,
                'role_id' => $this->role_id,
                'company_id' => $this->company_id,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
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

<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Models\{Role, Permission, PermissionForRole};
use Livewire\Component;

class Roles extends ModalComponent
{
    public $name;
    public $description;

    public $permission_id = [];

    public $permissions;

    protected $rules = [
        'name' => 'required|min:1|max:30',
        'description' => 'nullable|max:100',
    ];

    public function mount()
    {
        $this->permissions = Permission::get();
    }

    public function render()
    {
        return view('livewire.modal.store.roles', [
            'permissions' => $this->permissions,
        ]);
    }

    /* para la key */
    public function generarSlug($texto)
    {
        $slug = str_replace(' ', '-', $texto);

        // Convertir a minúsculas
        $slug = strtolower($slug);

        return $slug;
    }

    public function save()
    {
        $this->validate();

        try {

            $role = Role::create([
                'key' => $this->generarSlug($this->name),
                'name' => $this->name,
                'description' => $this->description,
            ]);

            foreach($this->permissions as $permission)
            {
                PermissionForRole::where('role_id', $role->id)->where('permission_id', $permission->id)->delete();   
            }

            foreach($this->permission_id as $key => $value)
            {
                $permission = Permission::select('id')->where('name', $value)->first();

                PermissionForRole::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id
                ]);
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Rol creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

            //return redirect(route('dashboard.roles'));

        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

}

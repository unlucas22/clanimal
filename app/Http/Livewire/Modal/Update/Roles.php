<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Models\{Role, Permission, PermissionForRole};
use Livewire\Component;

class Roles extends ModalComponent
{
    public $item_id;

    public $name;
    public $description;

    public $permission_id = [];

    public $permissions;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'description' => 'nullable|max:100',
    ];

    public function mount()
    {
        $item = Role::with('permission_for_roles')->where('id', $this->item_id)->firstOrFail();
        $this->name = $item->name;
        $this->description = $item->description;

        foreach ($item->permission_for_roles as $permission)
        {
            $this->permission_id[] = $permission->permissions->name;
        }

        $this->permissions = Permission::get();

    }

    public function render()
    {
        return view('livewire.modal.update.roles', [
            'permissions' => $this->permissions,
        ]);
    }

    public function save()
    {
        $this->validate();

        try {

            Role::where('id', $this->item_id)->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            foreach($this->permissions as $permission)
            {
                PermissionForRole::where('role_id', $this->item_id)->where('permission_id', $permission->id)->delete();   
            }

            foreach($this->permission_id as $key => $value)
            {
                $permission = Permission::select('id')->where('name', $value)->first();

                PermissionForRole::create([
                    'role_id' => $this->item_id,
                    'permission_id' => $permission->id
                ]);
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Rol actualizado con éxito',
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
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }

}

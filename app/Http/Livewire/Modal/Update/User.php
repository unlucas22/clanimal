<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Role, Company};
use Illuminate\Support\Facades\Log;

class User extends ModalComponent
{
    public $item_id;

    public $name;
    public $email;

    public $role_id;
    public $old_role_id;

    public $company_id;
    public $old_company_id;

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
        $this->old_role_id = $item->role_id;
        
        $this->company_id = $item->company_id;
        $this->old_company_id = $item->old_company_id;
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

        try {
            
            if($this->old_role_id != $this->role_id)
            {
                $new_rol = (Role::find(intval($this->role_id)))->name;

                \App\Models\User::setHistory([
                    'name' => 'users',
                    'formatted_name' => 'Rol',
                    'id' => $this->item_id,
                ], 'role_id', $new_rol);

            }
            else if($this->old_company_id != $this->company_id)
            {
                \App\Models\User::setHistory([
                    'name' => 'users',
                    'formatted_name' => 'Sede',
                    'id' => $this->item_id,
                ], 'company_id', (Company::where('id', $this->company_id))->name);
            }

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

            return redirect()->route('dashboard.users');
        } 
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error al actualizar los datos',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            Log::error($e->getMessage());
        }
    }
}

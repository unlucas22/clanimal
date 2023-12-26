<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use Livewire\Component;

/**
 * UNICAMENTE SE ASIGNAN LOS SUELDOS
 * */
class Puestos extends ModalComponent
{
    public $sueldo;

    public $role_id;

    protected $rules = [
        'sueldo' => 'required',
    ];

    public function mount()
    {
        $this->role_id = (Role::first())->id;
    }

    public function render()
    {
        return view('livewire.modal.store.puestos', [
            'roles' => Role::where('name', '!=', 'Administrador')->where('name', '!=', 'Default')->where('sueldo', null)->get(),
        ]);
    }

    public function save()
    {
        $this->validate();

        try {

            $role = Role::where('id', $this->role_id)->update([
                'sueldo' => $this->sueldo,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Puesto actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

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

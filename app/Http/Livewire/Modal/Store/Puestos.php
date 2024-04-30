<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Role;

class Puestos extends ModalComponent
{
    public $name;
    public $sueldo;

    protected $rules = [
        'name' => 'required',
        'sueldo' => 'required',
    ];

    public function save()
    {
        $this->validate();

        try
        {
            Role::create([
                'name' => $this->name,
                'sueldo' => $this->sueldo,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Puesto registrado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

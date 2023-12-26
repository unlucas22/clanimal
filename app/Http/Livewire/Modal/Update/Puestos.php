<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use Livewire\Component;

class Puestos extends ModalComponent
{
    public $item_id;

    public $name;
    public $description;
    public $sueldo;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'description' => 'nullable|max:100',
        'sueldo' => 'required',
    ];

    public function mount()
    {
        $item = Role::where('id', $this->item_id)->firstOrFail();
        
        $this->name = $item->name;
        $this->description = $item->description;
        $this->sueldo = $item->sueldo;
    }

    public function render()
    {
        return view('livewire.modal.update.puestos');
    }

    public function save()
    {
        $this->validate();

        try {

            Role::where('id', $this->item_id)->update([
                'name' => $this->name,
                'description' => $this->description,
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

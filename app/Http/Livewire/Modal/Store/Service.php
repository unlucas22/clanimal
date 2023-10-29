<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;

class Service extends ModalComponent
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'description' => 'nullable|max:100',
    ];

    public function render()
    {
        return view('livewire.modal.store.service');
    }

    public function submit()
    {
        $this->validate();

        try {

            \App\Models\Service::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Servicio creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            return redirect(route('dashboard.services'));
        
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

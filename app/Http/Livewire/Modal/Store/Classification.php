<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\Report;

class Classification extends ModalComponent
{
    public $key;
    public $name;

    protected $rules = [
        'key' => 'required|min:1|max:100',
        'name' => 'max:50',
    ];

    public function render()
    {
        return view('livewire.modal.store.classification');
    }

    public function submit()
    {
        $this->validate();

        try {

            Report::create([
                'name' => $this->name,
                'key' => $this->key,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Clasificación creado con éxito',
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

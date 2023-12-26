<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};
use App\Models\PaymentMethod;

class EntidadesBancarias extends ModalComponent
{
    public $name;

    public $rules = [
        'name' => 'required',
    ];

    public function render()
    {
        return view('livewire.modal.store.entidades-bancarias');
    }

    public function submit()
    {
        $this->validate();

        try {
            
            PaymentMethod::create([
                'name' => $this->name,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Entidad Bancaria registrado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

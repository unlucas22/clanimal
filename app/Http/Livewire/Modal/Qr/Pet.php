<?php

namespace App\Http\Livewire\Modal\Qr;

use LivewireUI\Modal\ModalComponent;

/**
 * Mostrar QR de la mascota para que lo escanee el cliente
 * */
class Pet extends ModalComponent
{
    public $link;

    public $pet;

    public function mount($pet_hashid)
    {
        $this->link = route('qr.client-pet', [
            'hashid' => $pet_hashid
        ]);

        $this->pet = \App\Models\Pet::with(['type_of_pets', 'clients'])->hashid($pet_hashid)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.modal.qr.pet');
    }
}

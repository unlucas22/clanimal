<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;

class PetImages extends Component
{
    public $pet_id;

    public function mount($pet_id)
    {
        $this->pet_id = $pet_id;
    }

    public function render()
    {
        return view('livewire.dashboard.create.pet-images');
    }
}

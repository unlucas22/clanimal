<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Models\PetPhotos;

class PetImages extends Component
{
    public function render()
    {
        return view('livewire.dashboard.show.pet-images', [
            'pet' => PetPhotos::where('pet_id', $req->pet_id)->get()
        ]);
    }
}

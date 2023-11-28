<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Http\Request;

class ClientPet extends Component
{
    public $pet;
    public $client;

    public function mount(Request $req)
    {    
        if($req->hashid == null)
        {
            return back();
        }

        $pet = \App\Models\Pet::with(['clients', 'type_of_pets', 'pet_photos'])->hashid($req->hashid)->firstOrFail();

        $this->pet = $pet;
        $this->client = $pet->clients;
    }

    public function render()
    {
        return view('livewire.dashboard.show.client-pet');
    }
}

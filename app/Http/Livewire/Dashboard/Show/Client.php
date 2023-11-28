<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;

class Client extends Component
{
    public $client;
    public $pets;
    public $pet_photos_count;

    public function mount($id)
    {
        $client = \App\Models\Client::with(['pets', 'users', 'reports'])->where('id', $id)->firstOrFail();

        $this->client = $client;
        $this->pets = $client->pets;
        $this->pet_photos_count = $client->pets->count();
    }

    public function render()
    {
        return view('livewire.dashboard.show.client');
    }
}

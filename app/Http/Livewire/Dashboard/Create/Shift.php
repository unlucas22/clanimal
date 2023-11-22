<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Pet, Service, Client};
use Illuminate\Http\Request;

class Shift extends Component
{
    /* mascotas del cliente */
    public $pets = [];
    public $dni;
    public $client;

    public function mount(Request $req)
    {
        if($req->hashid !== null){
            $client = Client::with('pets')->hashid($req->hashid)->firstOrFail();

            $this->dni = $client->dni;

            $this->client = $client->name;

            $this->pets = $client->pets;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.create.shift', [
            'services' => Service::get(),
        ]);
    }

    /* Buscar Cliente por DNI y llenar inputs */
    public function searchClient()
    {
        try {
            $client = Client::with('pets')->where('dni', $this->dni)->firstOrFail();


            $this->dni = $client->dni;

            $this->client = $client->name;

            $this->pets = $client->pets;

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'No se encontró al cliente con el dni proprocionado',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

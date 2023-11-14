<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Pet, Service, Client};

class Shift extends Component
{
    public $pets;
    public $dni;

    public function mount()
    {
        $this->pets = Pet::get();
    }

    public function render()
    {
        return view('livewire.dashboard.create.shift', [
            'services' => Service::get(),
        ]);
    }

    public function searchClient()
    {
        try {
            Client::with('pets')->where('dni', $this->dni)->firstOrFail();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'No se encontró al cliente con el dni: '.$this->dni,
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

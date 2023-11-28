<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Pet extends Component
{
    public $pet;
    public $client;
    public $pet_photos = [];

    public $note;

    public $rules = [
        'note' => 'required|min:1',
    ];

    public function mount(Request $req)
    {
        if($req->hashid == null)
        {
            return back();
        }

        $pet = \App\Models\Pet::with(['clients', 'type_of_pets', 'pet_photos'])->hashid($req->hashid)->firstOrFail();

        $this->pet = $pet;
        $this->client = $pet->clients;
        $this->pet_photos = $pet->pet_photos;

        $this->note = $pet->note ?? '';
    }

    public function render()
    {
        return view('livewire.dashboard.show.pet');
    }

    public function updateNote()
    {
        $this->validate();

        try {
            
            \App\Models\Pet::where('id', $this->pet->id)->update([
                'note' => $this->note,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Observación actualizada',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

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

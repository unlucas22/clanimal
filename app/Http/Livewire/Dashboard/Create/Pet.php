<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{TypeOfPet, Client};
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Pet extends Component
{

    public $dni;
    public $client;

    public $type_of_pets;

    /* datos de la mascota */
    public $pet_name;
    public $type_of_pet_id;
    public $pet_sex = 'macho';
    public $pet_age;
    /**
     * en proximas actualizaciones tendrá edad por meses, por el momento se puede poner 0.2 
     * */
    //public $pet_month;
    public $pet_height;
    public $pet_weight;
    public $pet_description;

    public $rules = [
        'dni' => 'required',

        'pet_name' => 'nullable|string|max:100',
        'type_of_pet_id' => 'nullable|integer',
        'pet_sex' => 'nullable|in:macho,hembra',
        'pet_age' => 'nullable|max:30',
        'pet_height' => 'nullable|min:0',
        'pet_weight' => 'nullable|min:0',
        'pet_description' => 'nullable|string',
    ];

    public function mount(Request $req)
    {
        if($req->hashid !== null){
            $client = Client::hashid($req->hashid)->firstOrFail();

            $this->dni = $client->dni;

            $this->client = $client->name;
        }

        $this->type_of_pets = TypeOfPet::get();

        if(count($this->type_of_pets))
        {
            $this->type_of_pet_id = $this->type_of_pets[0]->id;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.create.pet');
    }

    /**
     * Buscar el cliente por dni
     *  */
    public function searchClient()
    {
        $client = Client::where('dni', $this->dni)->first();

        if($client != null)
        {
            $this->client = $client->name;
        }
    }

    public function submit()
    {

        $this->validate();

        try {

            $client = Client::where('dni', $this->dni)->firstOrFail();

            \App\Models\Pet::create([
                'name' => $this->pet_name,
                'type_of_pet_id' => $this->type_of_pet_id,
                'gender' => $this->pet_sex,
                'age' => $this->pet_age,
                'height' => $this->pet_height,
                'weight' => $this->pet_weight,
                'note' => $this->pet_description,
                'client_id' => $client->id,
            ]);
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Mascota creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            return redirect()->route('dashboard.show.client', [
                'hashid' => $client->hashid,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            return false;
        }
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Pet, TypeOfPet};
use Illuminate\Support\Facades\Auth;
use DB;

class Client extends Component
{
    public $status = ['ocasional', 'regular', 'VIP'];

    public $type_of_pets;

    public $asign_pet = false;

    /* CLIENT */
    public $name;
    public $email;
    public $phone;
    public $address;
    public $status_id;

    /* PET */
    public $pet_name;
    public $type_of_pet_id;
    public $pet_sex;
    public $pet_age;
    //public $pet_month;
    public $pet_height;
    public $pet_weight;
    public $pet_description;

    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:clients,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'status_id' => 'nullable|string',

        'pet_name' => 'nullable|string|max:100',
        'type_of_pet_id' => 'nullable|integer',
        'pet_sex' => 'nullable|in:macho,hembra',
        'pet_age' => 'nullable|integer|min:0',
        // 'pet_month' => 'nullable|integer',
        'pet_height' => 'nullable|numeric|min:0',
        'pet_weight' => 'nullable|numeric|min:0',
        'pet_description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->type_of_pets = TypeOfPet::get();

        if(count($this->type_of_pets))
        {
            $this->type_of_pet_id = $this->type_of_pets[0]->id;
        }

        $this->status_id = 'ocasional';
    }
    
    public function render()
    {
        return view('livewire.dashboard.create.client');
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        /* Para la notificacion */
        $special_msg = '';

        try
        {
            $client = \App\Models\Client::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'status_id' => $this->status_id,
                'user_id' => Auth::user()->id,
            ]);

            if($this->asign_pet)
            {
                Pet::create([
                    'name' => $this->pet_name,
                    'type_of_pet_id' => $this->type_of_pet_id,
                    'sex' => $this->pet_sex,
                    'age' => $this->pet_age,
                    'height' => $this->pet_height,
                    'weight' => $this->pet_weight,
                    'note' => $this->pet_description,
                    'client_id' => $client->id,
                ]);

                $special_msg = 'Y Mascota ';
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Cliente '.$special_msg.'creado con éxito. Redireccionando...',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            DB::commit();

            $this->reset([
                'name',
                'email',
                'phone',
                'address',
                'pet_name',
                'pet_sex',
                'pet_age',
                'pet_height',
                'pet_weight',
                'pet_description',
            ]);

            return redirect()->route('dashboard.show.client', [
                'hashid' => $client->hashid,
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'green',
            ]);
        }
    }
}

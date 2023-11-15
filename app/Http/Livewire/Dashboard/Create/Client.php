<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{Pet, TypeOfPet, Report};
use Illuminate\Support\Facades\{Auth, Log};
use DB;

class Client extends Component
{
    /* Periocidad del cliente */
    public $status;
    /* periocidad del cliente seleccionado */
    public $status_id;

    public $type_of_pets;

    public $asign_pet = false;

    /* CLIENT */
    public $name;
    public $dni;
    public $last_name;
    public $email;
    public $phone;
    public $address;

    /* datos de la mascota */
    public $pet_name;
    public $type_of_pet_id;
    public $pet_sex;
    public $pet_age;
    /**
     * en proximas actualizaciones tendrá edad por meses, por el momento se puede poner 0.2 
     * */
    //public $pet_month;
    public $pet_height;
    public $pet_weight;
    public $pet_description;

    public $rules = [
        'name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'email' => 'required|email|max:255|unique:clients,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:50',
        'status_id' => 'nullable|string',
        'dni' => 'required',

        'pet_name' => 'nullable|string|max:100',
        'type_of_pet_id' => 'nullable|integer',
        'pet_sex' => 'nullable|in:macho,hembra',
        'pet_age' => 'nullable|max:30',
        'pet_height' => 'nullable|min:0',
        'pet_weight' => 'nullable|min:0',
        'pet_description' => 'nullable|string',
    ];

    public function mount()
    {
        $reports = Report::get();

        foreach ($reports as $report)
        {
            $this->status[] = $report->key;
        }

        $this->type_of_pets = TypeOfPet::get();

        if(count($this->type_of_pets))
        {
            $this->type_of_pet_id = $this->type_of_pets[0]->id;
        }

        /* Normalmente será 'default' la primera key */
        $this->status_id = (Report::first())->key;
    }
    
    public function render()
    {
        return view('livewire.dashboard.create.client');
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        /* Para la notificacion en SweetAlert */
        $special_msg = '';

        try
        {
            $report = Report::where('key', $this->status_id)->firstOrFail();

            $client = \App\Models\Client::create([
                'name' => $this->name.' '.$this->last_name,
                'email' => $this->email,
                'dni' => $this->dni,
                'phone' => $this->phone,
                'address' => $this->address,
                'report_id' => $report->id,
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
            Log::error($e->getMessage());
            
            DB::rollback();
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

    /**
     * Buscar el cliente por dni
     *  */
    public function searchClient() {

        $client = \App\Models\Client::where('dni', $this->dni)->first();

        if($client == null) {
            // api
            // return $json;
        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Cliente ya registrado. Redireccionando...',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            return redirect()->route('dashboard.show.client', [
                'hashid' => $client->hashid,
            ]);
        }

    }
}

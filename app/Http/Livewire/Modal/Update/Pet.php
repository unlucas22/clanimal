<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\TypeOfPet;

class Pet extends ModalComponent
{
    public $item_id;

    public $type_of_pets;

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

    public $rules = [
        'pet_name' => 'nullable|string|max:100',
        'type_of_pet_id' => 'nullable|integer',
        'pet_sex' => 'nullable|in:macho,hembra',
        'pet_age' => 'nullable|max:30',
        'pet_height' => 'nullable|min:0',
        'pet_weight' => 'nullable|min:0',
    ];

    public function mount($item_id)
    {
        $model = \App\Models\Pet::where('id', $item_id)->firstOrFail();
        
        $this->pet_name = $model->name;
        $this->type_of_pet_id = $model->type_of_pet_id;
        $this->pet_sex = $model->gender;
        $this->pet_age = $model->age;

        $this->pet_height = $model->height;
        $this->pet_weight = $model->weight;

        $this->type_of_pets = TypeOfPet::get();

        if(count($this->type_of_pets))
        {
            $this->type_of_pet_id = $this->type_of_pets[0]->id;
        }
    }

    public function render()
    {
        return view('livewire.modal.update.pet');
    }

    public function save()
    {
        $this->validate();

        try {

            \App\Models\Pet::where('id', $this->item_id)->update([
                'name' => $this->pet_name,
                'type_of_pet_id' => $this->type_of_pet_id,
                'gender' => $this->pet_sex,
                'age' => $this->pet_age,
                'height' => $this->pet_height,
                'weight' => $this->pet_weight,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Mascota actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
            
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

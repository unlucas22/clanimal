<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Casher, User, Company};
use Illuminate\Support\Facades\Log;

class Caja extends ModalComponent
{
    public $company_id;
    public $user_id;

    public $item_id;

    public $name;
    public $active;

    public $rules = [
        'name' => 'required|string|max:50',
        'user_id' =>  'required',
        'company_id' => 'required',
    ];

    public function mount($item_id)
    {
        $model = Casher::where('id', $item_id)->first();

        $this->user_id = $model->user_id;
        $this->company_id = $model->company_id;
        
        $this->name = $model->name;
        $this->active = $model->active;
    }

    public function render()
    {
        return view('livewire.modal.update.caja', [
            'users' => User::get(),
            'sedes' => Company::get(),
        ]);
    }

    public function save()
    {
        $this->validate();

        try {
            
            Casher::where('id', $this->item_id)->update([
                'user_id' => $this->user_id,
                'name' => $this->name,
                'company_id' => $this->company_id,
                'active' => $this->active,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Cajero actualizado con éxito',
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


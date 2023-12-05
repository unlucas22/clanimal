<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Casher, User, Company};
use Illuminate\Support\Facades\Log;

class Caja extends ModalComponent
{
    public $company_id;
    public $user_id;

    public $name;
    public $active = true;

    public $rules = [
        'name' => 'required|string|max:50',
        'user_id' =>  'required',
        'company_id' => 'required',
    ];

    public function mount()
    {
        $this->user_id = (User::first())->id;

        $this->company_id = (Company::first())->id;
    }

    public function render()
    {
        return view('livewire.modal.store.caja', [
            'users' => User::get(),
            'sedes' => Company::get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        try {
            
            Casher::create([
                'user_id' => $this->user_id,
                'name' => $this->name,
                'company_id' => $this->company_id,
                'active' => $this->active,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Cajero creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

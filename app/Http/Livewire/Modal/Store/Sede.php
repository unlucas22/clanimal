<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\Company;

class Sede extends ModalComponent
{
    public $name;
    public $address;
    public $email;
    public $phone;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'address' => 'nullable|max:100',
        'email' => 'max:50',
        'phone' => 'nullable|max:100',
    ];

    public function render()
    {
        return view('livewire.modal.store.sede');
    }

    public function submit()
    {
        $this->validate();

        try {

            Company::create([
                'name' => $this->name,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Sede creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            return redirect(route('dashboard.sedes'));
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

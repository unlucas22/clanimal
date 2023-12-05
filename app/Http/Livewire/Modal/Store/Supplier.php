<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Casher, User, Company};
use Illuminate\Support\Facades\Log;

class Supplier extends ModalComponent
{
    public $name;
    public $ruc;
    public $phone;
    public $address;

    public $rules = [
        'name' => 'required|string|max:50',
        'ruc' => 'max:12',
        'phone' => 'required|string|max:30',
        'address' => 'string|max:50',
    ];

    public function render()
    {
        return view('livewire.modal.store.supplier');
    }

    public function submit()
    {
        $this->validate();

        try {
            
            \App\Models\Supplier::create([
                'name' => $this->name,
                'ruc' => $this->ruc,
                'address' => $this->address,
                'phone' => $this->phone,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Proveedor registrado con éxito',
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

<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};

class ProductPresentation extends ModalComponent
{
    public $name;
    public $description;
    public $active = true;

    public $rules = [
        'name' => 'required|min:2|max:50',
        'description' => 'nullable|max:255',
    ];

    public function render()
    {
        return view('livewire.modal.store.product-presentation');
    }

    public function submit()
    {
        $this->validate();

        try {

            \App\Models\ProductPresentation::create([
                'name' => $this->name,
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Registrado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            return redirect()->route('product.presentations');
            
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

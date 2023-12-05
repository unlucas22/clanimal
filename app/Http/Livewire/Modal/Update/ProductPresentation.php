<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};

class ProductPresentation extends ModalComponent
{
    public $name;
    public $description;
    public $active;
    
    public $item_id;

    public $rules = [
        'name' => 'required|min:2|max:50',
        'description' => 'nullable|max:255',
    ];
    
    public function mount($item_id)
    {
        $model = \App\Models\ProductPresentation::where('id', $item_id)->firstOrFail();
        
        $this->name = $model->name;
        $this->description = $model->description;
        $this->active = $model->active;
    }


    public function render()
    {
        return view('livewire.modal.update.product-presentation');
    }

    public function save()
    {
        $this->validate();

        try {

            \App\Models\ProductPresentation::where('id', $this->item_id)->update([
                'name' => $this->name,
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Actualizado con éxito.',
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

<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\CashRegister;

class Ingreso extends ModalComponent
{
    public $status;
    
    public $item_id;

    public $rules = [
        'status' => 'required',
    ];

    public function mount($item_id)
    {
        $model = CashRegister::where('id', $item_id)->firstOrFail();
        
        $this->status = $model->status;
    }

    public function render()
    {
        return view('livewire.modal.update.ingreso');
    }

    public function save()
    {
        $this->validate();

        try {

            CashRegister::where('id', $this->item_id)->update([
                'status' => $this->status,
                'validated_at' => now(),
            ]);


            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado actualizado con éxito.',
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

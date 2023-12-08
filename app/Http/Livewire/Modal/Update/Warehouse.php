<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;

class Warehouse extends ModalComponent
{
    public $item_id;

    public $motivo;

    protected $rules = [
        'motivo' => 'required|min:1|max:100',
    ];

    public function render()
    {
        return view('livewire.modal.update.warehouse');
    }

    public function save()
    {
        $this->validate();

        try {

            \App\Models\Warehouse::where('id', $this->item_id)->update([
                'status' => 'cancelado',
                'motivo' => $this->motivo,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado de Compra actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
            
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

<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;

class FinanzasFacturas extends ModalComponent
{
    public $item_id;

    public $observation;

    public function render()
    {
        return view('livewire.modal.update.finanzas-facturas', [
            'item' => \App\Models\Warehouse::with(['product_in_warehouses', 'suppliers', 'users'])->where('id', $this->item_id)->first(),
        ]);
    }

    public function save()
    {
        try {

            \App\Models\Warehouse::where('id', $this->item_id)->update([
                'status' => 'contado',
                'observation' => $this->observation,
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
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

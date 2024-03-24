<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\{ProductForTransfer, Product, ProductStock};
use Illuminate\Support\Facades\Log;

/**
 * Cancelar estado
 * */
class Transfer extends ModalComponent
{
    public $item_id;

    public $motivo;

    protected $rules = [
        'motivo' => 'required|min:1|max:100',
    ];

    public function render()
    {
        return view('livewire.modal.update.transfer');
    }

    public function save()
    {
        $this->validate();

        try {

            $transfer = \App\Models\Transfer::with(['product_for_transfers', 'companies', 'users'])->where('id', $this->item_id)->first();


            foreach ($transfer->product_for_transfers as $transfer)
            {
                $pd = ProductStock::where('id', $transfer->product_stock_id)->first();
             
                $pd->update([
                    'stock' => $pd->stock + $transfer->stock
                ]);
            }


            \App\Models\Transfer::where('id', $this->item_id)->update([
                'status' => 'cancelado',
                'motivo' => $this->motivo,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado actualizado con éxito',
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

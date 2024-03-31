<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Warehouse;

class PagoCompletoWarehouse extends ModalComponent
{
    public $item_id;

    public $motivo;

    public $warehouse;

    protected $rules = [
        'motivo' => 'max:100',
    ];

    public function mount($item_id)
    {
        $this->warehouse = Warehouse::with(['product_in_warehouses', 'suppliers', 'users'])->where('id', $item_id)->first();
    }

    public function render()
    {
        return view('livewire.modal.update.pago-completo-warehouse');
    }

    public function save()
    {
        $this->validate();

        try
        {
            Warehouse::where('id', $this->item_id)->update([
                'status' => 'contado',
                'observation' => $this->motivo,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado de Compra actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
    
}

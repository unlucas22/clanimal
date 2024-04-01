<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\{WarehousePayment, WarehouseFeePayment};
 
class CuentasPorPagar extends ModalComponent
{
    public $warehouse_payment;

    public $listeners = ['pagarCuota'];

    public function mount($item_id)
    {
        $this->warehouse_payment = WarehousePayment::with(['warehouses', 'warehouse_fee_payments'])->where('id', $item_id)->first();
    }

    public function render()
    {
        return view('livewire.modal.update.cuentas-por-pagar');
    }

    public function pagarCuota($item_id)
    {
        try
        {
            WarehouseFeePayment::where('id', $item_id)->update([
                'status' => 'completado',
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado de Cuota actualizado con éxito',
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

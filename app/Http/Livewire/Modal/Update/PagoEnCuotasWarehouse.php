<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\{Warehouse, WarehousePayment, WarehouseFeePayment};
use DB;
use Carbon\Carbon;

class PagoEnCuotasWarehouse extends ModalComponent
{
    public $cuotas = 2;

    public function render()
    {
        return view('livewire.modal.update.pago-en-cuotas-warehouse');
    }

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

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try
        {
            Warehouse::where('id', $this->item_id)->update([
                'observation' => $this->motivo,
            ]);

            $wp = WarehousePayment::create([
                'cuotas' => $this->cuotas,
                'warehouse_id' => $this->item_id,
            ]);

            $parte = round($this->warehouse->total / $this->cuotas);
            $fechaActual = Carbon::now();

            for ($i=0; $i < $this->cuotas; $i++)
            { 
                WarehouseFeePayment::create([
                    'warehouse_payment_id' => $wp->id,
                    'cuota' => $parte,
                    'fecha' => $fechaActual->addMonth()->format('Y-m-d'),
                ]);
            }

            DB::commit();

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
            DB::rollback();
            Log::error($e);
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

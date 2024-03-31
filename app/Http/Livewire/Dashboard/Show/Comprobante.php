<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Traits\NubeFact;
use DB;

class Comprobante extends Component
{
    use NubeFact;

    public Bill $bill;

    public $listeners = ['cancelarOrden', 'procesarPago'];

    public function mount(Request $req)
    {
        $this->bill = Bill::with(['clients', 'users', 'product_for_sales'])->where('id', $req->bill_id)->first();
    }

    public function render()
    {
        return view('livewire.dashboard.show.comprobante');
    }

    public function cancelarOrden()
    {
        $this->bill->update([
            'status' => 'cancelado'
        ]);

        if($this->bill->metodo_de_pago == 'credito')
        {
            $this->bill->clients->update([
                'credito_actual' => $this->bill->clients->credito_actual - $this->bill->total,
            ]);
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Orden cancelada con éxito',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
    }

    public function procesarPago()
    {
        DB::beginTransaction();

        try
        {
            if($this->bill->factura == true)
            {
                $factura = $this->generarFactura($this->bill);

                if($factura == null)
                {
                    $this->withErrors([
                        'nubefact' => 'Hubo un error con NubeFact. Vuelva a intentarlo',
                    ]);

                    return false;
                }

                // Enlace de la factura en nubefact
                $enlace = 'https://www.nubefact.com/cpe/'.$factura['key'];

                $this->bill->update([
                    'enlace' => $enlace,
                ]);
            }

            $this->bill->update([
                'status' => 'completado'
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Orden procesado como completado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
            
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

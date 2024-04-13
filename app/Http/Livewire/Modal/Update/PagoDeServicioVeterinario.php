<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\{Sale, Client};
use DB;

class PagoDeServicioVeterinario extends ModalComponent
{
    public $item_id;

    public $client_razon_social;
    public $client_ruc;
    public $client_id;

    public $client_tarjeta;
    public $client_credito = null;
    public $client_linea_credito = null;

    public $total = 0;
    public $igv = 0;
    public $factura = true;
    public $radio = 'efectivo';

    public function mount($item_id)
    {
        $this->item_id = $item_id;

        $sale = Sale::where('id', $item_id)->first();

        $client = $sale->clients;

        $this->client_linea_credito = $client->linea_credito;
        $this->client_credito = $client->credito_actual;
        $this->client_id = $client->id;

        $this->total = ($sale->total * 0.18) + $sale->total;
    }

    public function render()
    {
        return view('livewire.modal.update.pago-de-servicio-veterinario');
    }

    public function save()
    {
        DB::beginTransaction();

        try
        {
            Sale::where('id', $this->item_id)->update([
                'metodo_de_pago' => $this->radio,
                'razon_social' => $this->client_razon_social ?? null,
                'ruc' => $this->client_ruc ?? null,
                'tarjeta' => $this->client_tarjeta ?? null,
                'factura' => $this->factura,
                'completed_at' => now(),
            ]);

            if($this->radio == 'credito')
            {
                $client = Client::where('id', $this->client_id)->first();

                $client->update([
                    'credito_actual' => $client->credito_actual + (($sale->total * 0.18) + $this->total),
                ]);
            }

            /* Asignar servicios a la venta */
            // $products = $this->asignProductToBill($req->productos_guardados, $bill->id);
            
            DB::commit();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Pago procesado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
            DB::rollback();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

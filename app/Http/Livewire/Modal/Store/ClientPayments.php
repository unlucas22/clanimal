<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{ClientPayment, Client};

class ClientPayments extends ModalComponent
{
    public $cuota;
    public $client_id;

    protected $rules = [
        'cuota' => 'required',
    ];

    public function mount($client_id)
    {
        $this->client_id = $client_id;
        $client = Client::where('id', $client_id)->first();

        $this->cuota = $client->credito_actual;
    }

    public function render()
    {
        return view('livewire.modal.store.client-payments');
    }

    public function submit()
    {
        $this->validate();

        try {

            ClientPayment::create([
                'cuota' => $this->cuota,
                'client_id' => $this->client_id,
            ]);

            $client = Client::where('id', $this->client_id)->first();

            $client->update([
                'credito_actual' => $client->credito_actual - $this->cuota,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Pago realizado con éxito',
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

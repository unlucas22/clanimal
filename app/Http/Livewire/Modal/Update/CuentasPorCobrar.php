<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\Client;

class CuentasPorCobrar extends ModalComponent
{
    public $client;
    public $pagar;
    
    public function mount($item_id, $pagar = true)
    {
        $this->client = Client::with(['bills', 'client_payments'])->where('id', $item_id)->first();
        $this->pagar = $pagar;
    }

    public function render()
    {
        return view('livewire.modal.update.cuentas-por-cobrar');
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
use App\Models\{Product, Client, User};

class Productos extends Component
{
    public $dni;
    public $client_id;

    public $client_name;

    public $pets = [];
    public $pet_id;

    public $user_referente;

    public $client_razon_social;

    public $client_ruc;

    public $factura = true;

    public $productos_guardados = [];

    /**
     * Buscar el cliente por dni
     *  */
    public function searchClient() {

        $client = Client::with('pets')->where('dni', $this->dni)->first();

        if($client != null) {
            $this->client_name = $client->name;
            $this->client_id = $client->id;

            $this->pets = $client->pets;

        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'No se encontró al cliente',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

    public function render()
    {
        $products = Product::with(['product_presentations', 'product_details'])->where('stock', '!=', 0)->limit(20)->get();

        return view('livewire.dashboard.create.venta.productos', [
            'products' => $products,
            'users' => User::get(),
        ]);
    }

    public function submit()
    {
        //
    }
}

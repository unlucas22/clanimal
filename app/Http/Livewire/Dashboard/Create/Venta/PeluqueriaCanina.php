<?php

namespace App\Http\Livewire\Dashboard\Create\Venta;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\{Pet, Client, User, Presale, Sale, Shift};
use Illuminate\Support\Facades\{Auth, Log};

class PeluqueriaCanina extends Component
{
    public $pet_id;
    public $pet_name;

    public $description;
    public $user_id;
    public $client_id;
    public $price;

    public $total = 0;

    public $sale_id;

    public $shift_id;

    public $listeners = ['enviarCaja'];

    public $rules = [
        'description' => 'required|string',
        'price' => 'required',
        'user_id' => 'required',
    ];

    public function mount(Request $req)
    {

        $shift = Shift::with('pets')->hashid($req->hashid)->firstOrFail();

        $this->shift_id = $shift->id;

        $pet = $shift->pets;

        $this->pet_id = $pet->id;
        $this->pet_name = $pet->name;

        $this->client_id = $pet->clients->id;

        $this->user_id = Auth::user()->id;

        /* Enlazar a una venta pero estará oculto hasta que se de a enviar caja */
        if(!Sale::where('active', false)->where('client_id', $this->client_id)->where('completed_at', null)->count())
        {
            $sale = Sale::create([
                'client_id' => $this->client_id,
                'user_id' => Auth::user()->id,
            ]);

            $this->sale_id = $sale->id;
        }
        else
        {
            /* Si ya existe tomar la preventa actual */
            $sale = Sale::where('active', false)->where('client_id', $this->client_id)->orderBy('created_at', 'desc')->first();

            $this->sale_id = $sale->id;
        }

        /* Apenas se entra al modulo cambia el estado del turno */
        Shift::where('id', $this->shift_id)->update([
            'status' => 'en atención',
        ]);
    }

    public function render()
    {
        $users = User::get();

        $presales = Presale::where('pet_id', $this->pet_id)->where('sale_id', $this->sale_id)->get();

        $total = 0;

        foreach ($presales as $presale)
        {
            $total += $presale->price;
        }

        $this->total = $total;

        return view('livewire.dashboard.create.venta.peluqueria-canina', [
            'users' => $users,
            'presales' => $presales,
        ]);
    }

    public function agregarItem()
    {
        $this->validate();

        try {

            $last_presale = Presale::create([
                'price' => $this->price,
                'description' => $this->description,
                'client_id' => $this->client_id,
                'user_id' => $this->user_id,
                'pet_id' => $this->pet_id,
                'sale_id' => $this->sale_id,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Servicio registrado creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->reset([
                'price',
                'description',
            ]);

            $this->emit('refreshComponent');

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

    public function eliminarPresale($item_id)
    {
        Presale::where('id', $item_id)->delete();

        $this->emit('refreshComponent');
    }

    public function enviarCaja()
    {
        try {
            
            /* Se muestra en caja */
            $sale = Sale::where('id', $this->sale_id)->update([
                'active' => true,
            ]);

            /* Se elimina el turno asignado para la mascota */
            Shift::where('id', $this->shift_id)->update([
                'status' => 'listo para retiro',
                'delivery_at' => now(),
            ]);

            /* regresa al modulo de atención */
            return redirect()->route('dashboard.peluqueria-canina');
            
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

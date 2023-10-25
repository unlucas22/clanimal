<?php

namespace App\Http\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Http\Request;
use App\Models\User;
use Hashids;

class Qr extends ModalComponent
{
    public $user_dni;
    public $link;

    protected $rules = [
        'user_dni' => 'required|min:8|max:50'
    ];

    /**
     *  Primero se pide la cedula
     *  y si encuentra el usuario muestra el qr 
     * */
    public function render()
    {
        return view('livewire.modal.qr');
    }

    /**
     *  con el link escaneado redirije a DashboardController con el id hasheado 
     * */
    public function submit()
    {
        $this->validate();

        try
        {
            $user = User::where('cedula', $this->user_dni)->firstOrFail();

            /* modificar config.app para obtener el timezone adecuado */
            $date = Hashids::encode(
                intval(now()->format('H'))
            );

            $this->link = route('qr.verification', [
                'hashid' => $user->hashid,
                'date' => $date,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Trabajador encontrado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
            
        }
        catch (\Exception $e)
        {
            \Log::error($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Trabajador con el dni '.$this->user_dni.' no encontrado, intente nuevamente.',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

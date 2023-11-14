<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\{User, Reason, Company};
use Hashids;
use Illuminate\Support\Facades\Validator;

class Control extends Component
{

    public function mount()
    {
        $this->motivo_id = (Reason::first())->id;
        $this->company_id = (Company::first())->id;
    }

    /**
     *  Primero se pide la cedula
     *  y si encuentra el usuario muestra el qr 
     * */
    public function render()
    {
        return view('livewire.control', [
            'motivos' => Reason::get(),
            'sedes' => Company::get(),
        ]);
    }

    public $user_dni;
    public $motivo_id;
    public $company_id;
    public $link;

    protected $rules = [
        'user_dni' => 'required|min:8|max:50',
        'motivo_id' => 'required',
        'company_id' => 'required',
    ];

    /**
     *  con el link escaneado redirije a DashboardController con el id hasheado 
     * */
    public function submit(Request $req)
    {
        $this->validate();

        /*
        $req->validate([
            'g-recaptcha-response' => ['required', 'captcha'],
        ],[
            'captcha' => 'Error en el Captcha. Vuelva a intentarlo.',
        ]);*/

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
                'motivo' => $this->motivo_id,
                'company' => $this->company_id,
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

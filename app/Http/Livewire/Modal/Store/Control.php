<?php

namespace App\Http\Livewire\Modal\Store;

use Illuminate\Http\Request;
use LivewireUI\Modal\ModalComponent;
use App\Models\{User, Reason, Company};
use Illuminate\Support\Facades\Log;
use BrowserDetect;

class Control extends ModalComponent
{
    public $dni;
    public $motivo_id;
    public $company_id;

    protected $rules = [
        'dni' => 'required|min:8|max:50',
        'motivo_id' => 'required',
        'company_id' => 'required',
    ];

    public function render()
    {
        return view('livewire.modal.store.control', [
            'users' => User::get(),
            'motivos' => Reason::get(),
        ]);
    }

    public function mount()
    {
        $this->motivo_id = (Reason::first())->id;
        $this->company_id = (Company::first())->id;
    }

    public function submit(Request $req)
    {
        $this->validate();

        try {

            $user = User::where('cedula', $this->dni)->firstOrFail();

            /* Juntar todos los datos del dispositivo en un string */
            $device = 'Navegador: '.BrowserDetect::browserName().' - SO: '.BrowserDetect::platformName().' - Dispositivo: '.BrowserDetect::deviceFamily();

            \App\Models\Control::create([
                'user_id' => $user->id,
                'ip' => $req->ipinfo->ip,
                'hostname' => $req->ipinfo->hostname ?? 'local',
                'city' => $req->ipinfo->city ?? 'local',
                'device' => $device,
                'reason_id' => $this->motivo_id,
                'company_id' => $this->company_id,
                'date' => now(),
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Registro creado con éxito',
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

<?php

namespace App\Http\Livewire\Modal\Store;

use Illuminate\Http\Request;
use LivewireUI\Modal\ModalComponent;
use App\Models\{User, Reason};
use Illuminate\Support\Facades\Log;
use BrowserDetect;

class Control extends ModalComponent
{
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
    }

    public $dni;
    public $motivo_id;

    protected $rules = [
        'dni' => 'required|min:8|max:50',
        'motivo_id' => 'required',
    ];

    public function submit(Request $req)
    {
        $this->validate();

        try {

            $user = User::where('cedula', $this->dni)->firstOrFail();

            $device = 'Navegador: '.BrowserDetect::browserName().' - SO: '.BrowserDetect::platformName().' - Dispositivo: '.BrowserDetect::deviceFamily();

            \App\Models\Control::create([
                'user_id' => $user->id,
                'ip' => $req->ipinfo->ip,
                'hostname' => $req->ipinfo->hostname ?? 'local',
                'city' => $req->ipinfo->city ?? 'local',
                'device' => $device,
                'reason_id' => $this->motivo_id,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Registro creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            return redirect(route('dashboard.controls'));
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

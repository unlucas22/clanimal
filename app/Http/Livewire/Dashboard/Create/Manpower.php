<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\{User, PaymentMethod, Role};
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

/**
 * Los datos del rol administrador y default no aparecerán, pero si en el search
 * */
class Manpower extends Component
{
    public $dni;

    public $user_id;
    public $user_name;
    public $user_email;
    public $user_phone;

    public $role_id;
    public $active;

    public $contact_name_emergency;
    public $contact_type_emergency;
    public $contact_phone_emergency;

    public $fecha_de_contratacion;

    public $cuenta_bancaria;

    public $payment_method_id;

    public function mount()
    {
        if(PaymentMethod::count())
        {
            $this->payment_method_id = (PaymentMethod::first())->id;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.create.manpower', [
            'payment_methods' => PaymentMethod::get(),
            'roles' => Role::where('name', '!=', 'Administrador')->where('name', '!=', 'Default')->get(),
        ]);
    }

    public function submit()
    {
        DB::beginTransaction();

        try {
            $fecha = Carbon::parse($this->fecha_de_contratacion.' '.Carbon::now()->format('H:i:s'));

            $mp = \App\Models\Manpower::updateOrCreate([
                'user_id' => $this->user_id,
            ], [
                'contact_name_emergency' => $this->contact_name_emergency,
                'contact_phone_emergency' => $this->contact_phone_emergency,
                'contact_type_emergency' => $this->contact_type_emergency,
                'cuenta_bancaria' => $this->cuenta_bancaria,
                'payment_method_id' => $this->payment_method_id,
                'fecha_de_contratacion' => $fecha,
            ]);

            $us = User::where('id', $this->user_id)->update([
                'phone' => $this->user_phone,
                'email' => $this->user_email,
                'role_id' => $this->role_id,
            ]);
            
            DB::commit();

            return redirect()->route('dashboard.recursos-humanos');
            
        } catch (\Exception $e) {

            Log::info($e->getMessage());

            DB::rollback();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error:'.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }

    public function search()
    {
        $user = User::with('roles')->where('cedula', $this->dni)->first();

        if($user != null)
        {
            $this->user_id = $user->id;
            $this->user_name = $user->name.' - '.$user->cedula;
            $this->user_email = $user->email;
            $this->user_phone = $user->phone;

            $this->role_id = $user->role_id;
            $this->active = $user->active;

            //mp
            $this->contact_name_emergency = $user->manpowers->contact_name_emergency;
            $this->contact_type_emergency = $user->manpowers->contact_type_emergency;
            $this->contact_phone_emergency = $user->manpowers->contact_phone_emergency;

            $this->fecha_de_contratacion = $user->manpowers->fecha_de_contratacion->format('d/m/Y');

            $this->cuenta_bancaria = $user->manpowers->cuenta_bancaria;

            $this->payment_method_id = $user->manpowers->payment_method_id;

        }
        else
        {
            $this->user_name = null;
            $this->user_email = null;
            $this->user_phone = null;

            $this->role_id = null;
            $this->active = null;

            $this->dispatchBrowserEvent('swal', [
                'title' => 'No se encontró al colaborador. Vuelva a intentarlo',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

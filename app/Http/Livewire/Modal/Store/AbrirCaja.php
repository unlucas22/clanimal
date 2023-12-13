<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\CashRegister;
use Illuminate\Support\Facades\{Log, Auth};
use DB;

class AbrirCaja extends ModalComponent
{
    public $en_caja = 0;

    public function render()
    {
        return view('livewire.modal.store.abrir-caja');
    }

    public function submit()
    {
        //$this->validate();

        DB::beginTransaction();

        try {

            CashRegister::create([
                'casher_id' => Auth::user()->cashers[0]->id,
                'en_caja' => $this->en_caja,
                'status' => 'en proceso',
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Caja abierto creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            DB::commit();

            $this->emit('refreshParent');

            $this->closeModal();

        } catch (\Exception $e) {
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

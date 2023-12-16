<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};

class Finance extends ModalComponent
{
    public $monto_efectivo;
    public $monto_tarjetas;

    public $numero_operacion;

    public $reported_at;

    public $rules = [
        //'reported_at'
        // 'monto_efectivo' => 'required|string|max:50',
        // 'monto_tarjetas' =>  'required',
        'numero_operacion' => 'required',
    ];

    public function render()
    {
        return view('livewire.modal.store.finance');
    }

    public function submit()
    {
        $this->validate();

        try {
            
            \App\Models\Finance::create([
                'user_id' => Auth::user()->id,
                'total_efectivo' => $this->monto_efectivo,
                'total_tarjetas' => $this->monto_tarjetas,
                'numero_operacion' => $this->numero_operacion,
                'reported_at' => now(),
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Reporte diario de Finanzas creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

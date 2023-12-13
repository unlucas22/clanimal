<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Models\CashRegister;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use DB;

class Caja extends Component
{
    public $caja;

    public $en_caja = 0;

    public $total_efectivo = 0;
    public $total_tarjeta = 0;
    public $total_virtual = 0;

    public function mount(Request $req)
    {    
        if($req->hashid == null)
        {
            return back();
        }

        $caja = CashRegister::with('cashers')->hashid($req->hashid)->firstOrFail();

        $this->caja = $caja;

        $this->en_caja = $caja->en_caja;
    }

    public function render()
    {
        return view('livewire.dashboard.show.caja', [
            'caja' => $this->caja,
        ]);
    }

    public function submit()
    {
        DB::beginTransaction();

        try {

            CashRegister::where('id', $this->caja->id)->update([
                'closed_at' => now(),
                'total_efectivo' => $this->total_efectivo,
                'total_tarjeta' => $this->total_tarjeta,
                'total_virtual' => $this->total_virtual,
                'status' => 'validacion',
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Actualizado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            DB::commit();

            $this->emit('refreshComponent');
            
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

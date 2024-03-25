<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{User, Spreadsheet};
use Illuminate\Support\Facades\{Log, Auth};
use Illuminate\Http\Request;
use Hashids;
use DB;

class UserForSpreadsheet extends ModalComponent
{
    public $item_id;

    public $observation;
    public $sueldo;

    /* Descuentos */
    public $aportes;

    public $dias_no_laborados = 0;

    public $minutos_de_tardanzas = 0;

    public $monto_bonificacion = 0;

    public function mount($item_id)
    {
        $model = \App\Models\UserForSpreadsheet::with('users')->where('id', $item_id)->first();

        $this->status = $model->status;

        $this->sueldo = $model->users->roles->sueldo;

        $this->aportes = $model->aportes;
        $this->dias_no_laborados = $model->dias_no_laborados;
        $this->minutos_de_tardanzas = $model->minutos_de_tardanzas;
        $this->monto_bonificacion = $model->bonificacion;

        $this->observation = $model->observation;
    }
 
    public function render()
    {
        return view('livewire.modal.store.user-for-spreadsheet', [
            'item' => \App\Models\UserForSpreadsheet::with(['spreadsheets', 'users'])->where('id', $this->item_id)->first()
        ]);
    }

    protected function aplicarDescuentos()
    {
        $monto_descuento_por_faltas = ($this->sueldo / 30) * intval($this->dias_no_laborados);

        $monto_tardanza = 0;

        if($this->minutos_de_tardanzas > 0 && $this->minutos_de_tardanzas < 30)
        {
            $monto_tardanza = 40;
        }
        else if($this->minutos_de_tardanzas >= 30 && $this->minutos_de_tardanzas < 60)
        {
            $monto_tardanza = 80;
        }
        else if($this->minutos_de_tardanzas >= 60)
        {
            $monto_tardanza = 200;
        }

        return $monto_tardanza + intval($monto_descuento_por_faltas) + $this->aportes;
    }

    public function submit()
    {
        try
        {
            $descuento = $this->aplicarDescuentos();
            
            \App\Models\UserForSpreadsheet::where('id', $this->item_id)->update([
                'observation' => $this->observation,
                'descuento' => $descuento,
                'bonificacion' => intval($this->monto_bonificacion),
                'dias_no_laborados' => intval($this->dias_no_laborados),
                'minutos_de_tardanzas' => intval($this->minutos_de_tardanzas),
                'aportes' => $this->aportes,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Detalles actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        }
        catch (\Exception $e)
        {
            Log::info($e);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}
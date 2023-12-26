<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};

class Finance extends ModalComponent
{
    public $item_id;

    public $status_id;
    public $status;

    public $observation;

    public $can_modify;

    public function mount($item_id, $g = false)
    {
        $model = \App\Models\Finance::where('id', $item_id)->first();

        $this->status_id = $model->status;

        $this->observation = $model->observation;

        $this->can_modify = boolval($g);
    }

    public function render()
    {
        return view('livewire.modal.update.finance', [
            'item' => \App\Models\Finance::with('users')->where('id', $this->item_id)->first()
        ]);
    }

    public function save()
    {
        try {
            
            \App\Models\Finance::where('id', $this->item_id)->update([
                'status' => $this->status,
                'observation' => $this->observation,
            ]);

            if($this->status == 'completado' && $this->can_modify)
            {
                \App\Models\Finance::where('id', $this->item_id)->update([
                    'validated_at' => now(),
                ]); 
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Reporte diario a finanza actualizado con éxito',
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

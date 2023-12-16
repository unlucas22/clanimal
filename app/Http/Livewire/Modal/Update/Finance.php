<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};

class Finance extends ModalComponent
{

    public $item_id;

    public $status_id;
    public $status;

    public function mount($item_id)
    {
        $model = \App\Models\Finance::where('id', $item_id)->first();

        $this->status_id = $model->status;
    }

    public function render()
    {
        return view('livewire.modal.update.finance');
    }

    public function save()
    {
        try {
            
            \App\Models\Finance::where('id', $this->item_id)->update([
                'status' => $this->status,
            ]);

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

<?php

namespace App\Http\Livewire\Modal\Update;

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

    public $status;

    public $can_modify;

    public function mount($item_id, $g = false)
    {
        $model = \App\Models\UserForSpreadsheet::where('id', $item_id)->first();

        $this->status = $model->status;

        $this->observation = $model->observation;

        $this->can_modify = boolval($g);
    }
 
    public function render()
    {
        return view('livewire.modal.update.user-for-spreadsheet', [
            'item' => \App\Models\UserForSpreadsheet::with(['spreadsheets', 'users'])->where('id', $this->item_id)->first()
        ]);
    }

    public function save()
    {
        try {
            
            \App\Models\UserForSpreadsheet::where('id', $this->item_id)->update([
                'status' => $this->status,
                'observation' => $this->observation,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Detalles y estado actualizado con éxito',
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

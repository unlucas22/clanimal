<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Traits\HasStatus;

class ShiftStatus extends ModalComponent
{
    use HasStatus;
    
    public $item_id;
    public $status_id;
    
    protected $listeners = [
       'statusSelected'
    ];

    public function mount($item_id, $status_id)
    {
        $this->item_id = $item_id;

        $this->status_id = $status_id;
    }

    public function render()
    {
        return view('livewire.modal.update.shift-status');
    }

    public function statusSelected($value)
    {
        try
        {
            \App\Models\Shift::where('id', $this->item_id)->update([
                'status' => $value,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado actualizado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

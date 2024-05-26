<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Alert;

class Notification extends ModalComponent
{
    public $item_id;

    public Alert $alert;

    protected $rules = [
        'alert.title' => 'required|max:50',
        'alert.message' => 'max:250',
        'alert.email' => 'max:3',
    ];

    public function mount()
    {
        $this->alert = Alert::where('id', $this->item_id)->firstOrFail();
    }

    public function updatedAlertEmail()
    {
        $this->alert->save();
    }

    public function save()
    {
        $this->validate();

        try {
            $this->alert->save();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Datos actualizados',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        } 
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error al actualizar los datos',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            Log::error($e->getMessage());
        }
    }
}

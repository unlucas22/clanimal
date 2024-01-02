<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};
use App\Models\PaymentMethod;

class EntidadesBancarias extends ModalComponent
{
    public $name;
    public $item_id;

    public $rules = [
        'name' => 'required',
    ];

    public function mount($item_id)
    {
        $model = PaymentMethod::where('id', $item_id)->first();

        $this->item_id = $item_id;

        $this->name = $model->name;
    }

    public function render()
    {
        return view('livewire.modal.update.entidades-bancarias');
    }

    public function submit()
    {
        $this->validate();

        try {
            
            PaymentMethod::where('id', $this->item_id)->update([
                'name' => $this->name,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Entidad Bancaria registrado con éxito',
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

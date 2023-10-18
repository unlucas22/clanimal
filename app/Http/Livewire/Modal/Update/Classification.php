<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\Report;

class Classification extends ModalComponent
{
    public $item_id;

    public $key;
    public $name;

    protected $rules = [
        'key' => 'required|min:1|max:100',
        'name' => 'max:50',
    ];

    public function mount()
    {
        $item = Report::where('id', $this->item_id)->firstOrFail();

        $this->key = $item->key;
        $this->name = $item->name;
    }

    public function render()
    {
        return view('livewire.modal.update.classification');
    }


    public function submit()
    {
        $this->validate();

        Report::where('id', $this->item_id)->update([
            'name' => $this->name,
            'key' => $this->key,
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Datos actualizados',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
    }

}

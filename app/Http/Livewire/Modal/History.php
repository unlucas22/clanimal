<?php

namespace App\Http\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;

class History extends ModalComponent
{
    public $item_id;

    public function render()
    {
        return view('livewire.modal.history', [
            'histories' => \App\Models\History::where('user_id', $this->item_id)->paginate(4)
        ]);
    }
}

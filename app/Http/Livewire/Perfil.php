<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hashids;
use App\Models\{User, Control};

class Perfil extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = Hashids::decode($user_id);
    }

    public function render()
    {
        $user = User::find($this->user_id)->firstOrFail();

        $control = Control::where('user_id', $user->id)->firstOrFail();

        return view('livewire.perfil', [
            'user' => $user,
            'control' => $control,
        ]);
    }
}

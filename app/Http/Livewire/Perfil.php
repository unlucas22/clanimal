<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{User, Control};
use Hashids;

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

        $control = Control::with('reasons')->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();

        return view('livewire.perfil', [
            'user' => $user,
            'control' => $control,
        ]);
    }
}

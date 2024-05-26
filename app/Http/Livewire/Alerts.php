<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class Alerts extends Component
{
    public $notices = [];

    public $listeners = ['cerrarTodo', 'cerrar'];
    
    public function __construct()
    {
        $this->notices = Notice::with('alerts')->where('user_id', Auth::user()->id)->get();
    }

    public function cerrarTodo()
    {
        Notice::where('user_id', Auth::user()->id)->delete();

        $this->emit('refreshComponent');
    }

    public function cerrar($notice_id)
    {
        Notice::where('user_id', Auth::user()->id)->where('id', $notice_id)->delete();

        $this->emit('refreshComponent');
    }
}

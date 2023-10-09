<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Greeting extends Component
{
    public $greeting;

    public function __construct()
    {
        $this->greeting = $this->greetingWord();
    }

    public function render()
    {
        return view('livewire.dashboard.greeting');
    }

    protected function greetingWord()
    {
        $name = Str::words(Auth::user()->name, 1, '').'!';

        $msg = '¡';

        $hour = date("G");

        if($hour >= 3 && $hour < 12)
        {
            $msg .= "Buen día";
        }
        else if($hour >= 12 && $hour < 19)
        {
            $msg .= 'Buenas tardes';
        }
        else
        {
            $msg .= 'Buenas noches';
        }

        return $msg.' '.$name;
    }
}
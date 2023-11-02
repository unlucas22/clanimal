<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class SideNavigation extends Component
{
    public $default;

    public function mount()
    {
        $this->default = Cookie::has('sidebar') ? Cookie::get('sidebar') : 'true';
    }

    public function render()
    {
        return view('livewire.side-navigation');
    }
}

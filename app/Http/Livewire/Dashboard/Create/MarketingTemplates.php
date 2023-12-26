<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
use App\Models\MarketingTemplate;

class MarketingTemplates extends Component
{
    public $name;
    public $content;

    public $button_text;
    public $button_url;

    public function render()
    {
        return view('livewire.dashboard.create.marketing-templates');
    }
}

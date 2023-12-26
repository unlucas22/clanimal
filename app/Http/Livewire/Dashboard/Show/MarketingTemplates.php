<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MarketingTemplates extends Component
{
    public $name;
    public $content;

    public $image;

    public $button_text;
    public $button_url;

    public $template_id;

    public function mount(Request $req)
    {    
        if($req->hashid == null)
        {
            return back();
        }

        $model = \App\Models\MarketingTemplate::hashid($req->hashid)->firstOrFail();

        $this->name = $model->name;
        $this->content = $model->content;

        $this->image = $model->image;

        $this->button_text = $model->button_text;
        $this->button_url = $model->button_url;

        $this->template_id = $model->id;
    }

    public function render()
    {
        return view('livewire.dashboard.show.marketing-templates');
    }
}

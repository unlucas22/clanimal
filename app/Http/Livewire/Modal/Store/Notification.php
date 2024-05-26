<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use App\Models\Alert;
use App\Jobs\ProcessGlobalNotice;

class Notification extends ModalComponent
{
    public $title;
    public $message;
    public $type = 'success';
    public $global = false;

    public $email = false;
    public $button_text;
    public $button_url;

    public $types = ['success', 'warning', 'error'];

    protected $rules = [
        'title' => 'required|max:50',
        'message' => 'max:250',
    ];

    public function submit()
    {
        $this->validate();

        try {

            $alert = Alert::create([
                'title' => $this->title,
                'message' => $this->message,
                'type' => $this->type,
                'email' => $this->email,
            ]);

            ProcessGlobalNotice::dispatchIf($this->global, $alert->id);
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notificación registrado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Auth, Log};

class Control extends ModalComponent
{
    public $item_id;

    public $ip;
    public $hostname;
    public $device;
    public $city;
    public $confirmed;

    public $user_id;

    public $rules = [
        'ip' => 'required',
        'device' => 'required',
    ];

    public function mount()
    {
        $item = \App\Models\Control::where('id', $this->item_id)->firstOrFail();

        $this->ip = $item->ip;
        $this->hostname = $item->hostname;
        $this->device = $item->device;
        $this->city = $item->city;
        $this->confirmed = $item->confirmed;

        $this->user_id = $item->user_id;
    }

    public function render()
    {
        /* dejarlo por el momento como testeo */
        // $users = User::get();

        return view('livewire.modal.update.control');
    }

    public function save()
    {
        $this->validate();

        try
        {
            \App\Models\Control::where('id', $this->item_id)->update([
                'ip' => $this->ip,
                'hostname' => $this->hostname,
                'device' => $this->device,
                'city' => $this->city,
                'confirmed' => $this->confirmed,
                //'user_id' => Auth::user()->id
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Control actualizado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

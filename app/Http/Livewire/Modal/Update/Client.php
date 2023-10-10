<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;

class Client extends ModalComponent
{
    public $status = ['ocasional', 'regular', 'VIP'];

    public $item_id;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $status_id;

    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'status_id' => 'nullable|string',
    ];

    public function mount()
    {
        $item = \App\Models\Client::where('id', $this->item_id)->firstOrFail();

        $this->name = $item->name;
        $this->email = $item->email;
        $this->phone = $item->phone;
        $this->address = $item->address;

        $this->status_id = $item->status;
    }

    public function render()
    {
        return view('livewire.modal.update.client', [
            'status' => $this->status,
        ]);
    }

    public function save()
    {
        $this->validate();

        try
        {
            \App\Models\Client::where('id', $this->item_id)->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'status' => $this->status_id,
                'user_id' => Auth::user()->id,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Cliente '.$this->name.' actualizado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

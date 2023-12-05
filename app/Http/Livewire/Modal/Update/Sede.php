<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class Sede extends ModalComponent
{
    public $item_id;

    public $name;
    public $address;
    public $email;
    public $phone;

    protected $rules = [
        'name' => 'required|min:1|max:100',
        'address' => 'nullable|max:100',
        'email' => 'max:50',
        'phone' => 'nullable|max:100',
    ];

    public function mount()
    {
        $item = Company::where('id', $this->item_id)->firstOrFail();
        $this->name = $item->name;
        $this->address = $item->address;
        $this->email = $item->email;
        $this->phone = $item->phone;
    }

    public function render()
    {
        return view('livewire.modal.update.sede');
    }

    public function save()
    {
        $this->validate();

        try {

            Company::where('id', $this->item_id)->update([
                'name' => $this->name,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Sede actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

            //return redirect(route('dashboard.sedes'));
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

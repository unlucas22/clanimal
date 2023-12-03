<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Models\{Role, Permission};

class Roles extends ModalComponent
{
    public $item_id;

    public $name;
    public $key;
    public $description;

    protected $rules = [
        'key' => 'required|min:1|max:100',
        'name' => 'required|min:1|max:100',
        'description' => 'nullable|max:100',
    ];

    public function mount()
    {
        $item = Role::where('id', $this->item_id)->firstOrFail();
        $this->name = $item->name;
        $this->key = $item->key;
        $this->description = $item->description;
    }

    public function render()
    {
        return view('livewire.modal.update.roles');
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

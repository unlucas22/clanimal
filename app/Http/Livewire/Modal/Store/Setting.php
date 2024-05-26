<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Setting extends ModalComponent
{
    use WithFileUploads;

    public $file;

    public $type = 'string';
    public $types = ['numeric' => 'Númerico', 'string' => 'Texto', /*'image' => 'Imagen',*/ 'url' => 'Link'];

    public $key;
    public $value;
    public $description;

    protected $rules = [
        'description' => 'max:100',
        'value' => 'required',
        'key' => 'required|max:100',
    ];

    public function updatedType($value)
    {
        $this->type = $value;

        $this->emit('refreshComponent');
    }

    public function save()
    {
        $this->validate();

        try {

            if($this->type == 'image')
            {
                $this->validate([
                    'file' => 'required|image',
                ]);

                $this->value = $this->file->storePublicly(now()->format('d-m-Y'), 'public');
            }

            \App\Models\Setting::create([
                'key' => str_replace(' ', '_', strtolower($this->key)),
                'value' => $this->value,
                'description' => $this->description,
                'type' => $this->type,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Datos actualizados',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();
        } 
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error al actualizar los datos',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            Log::error($e);
        }
    }
}

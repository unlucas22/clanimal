<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Setting extends ModalComponent
{
    use WithFileUploads;

    public $file;

    public $item_id;

    public \App\Models\Setting $setting;

    protected $rules = [
        //'user.type' => 'required',
        'setting.description' => 'required|max:100',
        'setting.value' => 'required',
    ];

    public function mount()
    {
        $this->setting = \App\Models\Setting::where('id', $this->item_id)->firstOrFail();
    }

    public function save()
    {
        $this->validate();

        try {

            if($this->setting->type == 'image')
            {
                $this->validate([
                    'file' => 'required|image',
                ]);

                $this->setting->value = $this->file->storePublicly(now()->format('d-m-Y'), 'public');
            }

            $this->setting->save();

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

            Log::error($e->getMessage());
        }
    }
}

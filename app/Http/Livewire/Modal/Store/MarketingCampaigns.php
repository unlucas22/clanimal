<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\{Log, Auth};
use App\Models\{MarketingTemplate, MarketingCampaign, Client, MarketingTracking};

class MarketingCampaigns extends ModalComponent
{
    public $plantilla_id;
    public $name;
    public $fecha;

    public $rules = [
        'fecha' => 'required',
        'name' => 'required',
    ];

    public function mount()
    {
        $this->plantilla_id = (MarketingTemplate::first())->id ?? 0;

        $this->fecha = now()->format('m/d/Y');
    }

    public function render()
    {
        return view('livewire.modal.store.marketing-campaigns', [
            'plantillas' => MarketingTemplate::get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        try {
            
            $marketing_campaign = MarketingCampaign::create([
                'name' => $this->name,
                'fecha' => $this->fecha,
                'marketing_template_id' => $this->plantilla_id,
            ]);

            $users = Client::get();

            foreach ($users as $user)
            {
                MarketingTracking::create([
                    'marketing_campaign_id' => $marketing_campaign->id,
                    'user_id' => $user->id,
                ]);
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Campaña de Marketing creado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->emit('refreshParent');

            $this->closeModal();

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\MarketingCampaign;

class MarketingCampaigns extends Component
{
    use HasTable;

    public $title = 'Campañas de Marketing';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre de campaña',
        'formatted_fecha' => 'Fecha de programación',
        'formatted_status' => 'Estado',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh', 'ejecutarJob'];

    public function ejecutarJob()
    {
        \App\Jobs\SendMarketingEmail::dispatch();

        $this->dispatchBrowserEvent('swal', [
            'title' => '¡Jobs ejecutados con éxito!',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);

        $this->emit('refreshComponent');
    }

    public function getItems()
    {
        $query = MarketingCampaign::query();

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%');
        }

        $query->withCount(['marketing_trackings']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'marketing_campaigns';

        $this->relationships = [
            'Cantidad de correos a enviar',
        ];

        $this->relationship_name = 'marketing-campaigns';

        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'peluqueria-canina',
            'head_name' => 'marketing-campaigns',
        ]);
    }
}

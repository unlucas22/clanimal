<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\MarketingTracking;

class MarketingTrackings extends Component
{
    use HasTable;

    public $title = 'Trackings de Campañas';

    public $columns = [
        'id' => 'ID',
        'formatted_status' => 'Estado',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = MarketingTracking::query();

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%');
        }

        $query->with(['users', 'marketing_campaigns']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'marketing_trackings';

        $this->relationships = [
            'Nombre de campaña',
            'Nombre de Destinatario',
            'Email de Destinatario',
            'Fecha de envío',
        ];

        $this->relationship_name = 'marketing-trackings';

        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            // 'action_name' => 'peluqueria-canina',
            // 'head_name' => 'turno',
        ]);
    }
}

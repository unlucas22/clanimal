<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\MarketingTemplate;

class MarketingTemplates extends Component
{
    use HasTable;

    public $title = 'Plantillas para Campañas';

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombre de Plantilla',
        'button_text' => 'Botón',
        'button_url' => 'URL de Botón',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh'];

    public function getItems()
    {
        $query = MarketingTemplate::query();

        if($this->search != '')
        {
            $query->where('id', 'like', '%' . $this->search . '%');
        }
        
        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'marketing_templates';

        $this->relationships = [
        ];

        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'marketing-templates',
            'head_name' => 'marketing-templates',
        ]);
    }
}

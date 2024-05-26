<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Alert, Notice};

class Notificaciones extends Component
{
    use HasTable;

    public $title = 'Notificaciones';

    public $columns = [
        'id' => 'ID',
        'title' => 'Titulo',
    ];

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh', 'deleteItem'];

    public function getItems()
    {
        $query = Alert::query();

        $query->withCount('notices');

        if($this->search != '')
        {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('message', 'like', '%' . $this->search . '%')
                ->orWhere('type', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'alert';

        $this->relationships = [
            'Mensaje',
            'Tipo de Alerta',
            'Usuarios',
            'Envío por Email',
        ];

        $this->canActive = true;

        $this->created_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'notification',
            'head_name' => 'notification',
        ]);
    }

    public function deleteItem($item_id)
    {
        try {
            Notice::where('alert_id', $item_id)->delete();

            Alert::where('type', '!=', 'warning')->where('id', $item_id)->delete();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notificación eliminado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Spreadsheet, User, UserForSpreadsheet};
use Illuminate\Support\Facades\{Log, Auth};
use DB;

class RrhhPlanillas extends Component
{
    use HasTable;

    public $title = 'Planillas';

    public $description = 'Planillas de pago a colaboradores';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh', 'enviarPlanilla'];
    
    public $search = '';

    public function delete($item_id)
    {
        $this->deleteItem($item_id);

        $this->emit('refreshComponent');
    }

    public function getItems()
    {
        $query = Spreadsheet::query();

        if($this->search != '')
        {
            $query->where('status', 'like', '%' . $this->search . '%')
                ->orWhere('validated_at', 'like', '%' . $this->search . '%');
        }

        $query->with('user_for_spreadsheets');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);;
    }

    public function render()
    {
        $this->table = 'spreadsheets';

        $this->relationships = [
            'Mes - Año',
            'Trabajadores',
            'Monto total',
            'Estado',
            //'Fecha de creación',
            'Fecha de Validación',
        ];

        $this->relationship_name = 'finanzas-planillas';

        //$this->created_at = false;
        $this->updated_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'rrhh-planillas',
            'head_name' => 'finanzas-planillas',
        ]);
    }

    public function enviarPlanilla($item_id)
    {
        $spreadsheet = Spreadsheet::with('user_for_spreadsheets')->where('id', $item_id)->first();

        foreach ($spreadsheet->user_for_spreadsheets as $user)
        {
            $user->update([
                'status' => 'validacion',
            ]);    
        }

        $spreadsheet->update([
            'status' => 'validacion',
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Estado actualizado con éxito',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);

        $this->emit('refreshComponent');
    }
}

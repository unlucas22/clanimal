<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{User, UserForSpreadsheet};
use Illuminate\Support\Facades\{Log, Auth};
use Illuminate\Http\Request;
use Hashids;
use DB;

class RrhhSpreadsheet extends Component
{
    use HasTable;

    public $title = 'Planilla';

    public $hashid;

    public $description = 'Planillas de pago a colaboradores';

    public $columns = [
        //'id' => 'ID',
    ];

    public $listeners = ['refreshParent' => '$refresh', 'enviarPlanilla'];

    public $search = '';

     public function mount(Request $req)
    {
        if($req->hashid == null)
        {
            return back();
        }

        $this->hashid = $req->hashid;
    }

    public function getItems()
    {
        $query = \App\Models\UserForSpreadsheet::query();

        $query->where('spreadsheet_id', Hashids::decode($this->hashid));

        if($this->search != '')
        {
            $query->where('status', 'like', '%' . $this->search . '%')
                ->orWhere('validated_at', 'like', '%' . $this->search . '%');
        }

        $query->with(['spreadsheets', 'users']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(25);
    }

    public function render()
    {
        $this->table = 'spreadsheets';

        $this->relationships = [
            'Nombres y Apellidos',
            'Cargo',
            'Sueldo',
            'Días no laborados',
            'Minutos de tardanzas',
            'Descuentos',
            'Bonificación',
            'Salario Final',
            'Estado',
        ];

        $this->relationship_name = 'finanzas-planillas-colaboradores';

        $this->created_at = false;
        $this->updated_at = false;
        $this->can_delete = false;

        $user_for_spreadsheets = $this->getItems();

        $this->description = 'Planilla '.$user_for_spreadsheets[0]->spreadsheets->fecha->format('m/Y');

        $this->title = 'Relación de colaboradores';

        return view('livewire.dashboard.table', [
            'items' => $user_for_spreadsheets,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'rrhh-planillas-colaboradores',
            'head_name' => 'relacion-de-colaboradores',
        ]);
    }

    public function enviarPlanilla($item_id)
    {
        $ufs = \App\Models\UserForSpreadsheet::where('id', $item_id)->first();

        $ufs->update([
            'status' => 'validacion',
        ]);

        if(
            $ufs->dias_no_laborados == null 
            && $ufs->minutos_de_tardanzas == null 
            && $ufs->bonificacion == null
            && $ufs->descuento == null
        )
        {
            $ufs->update([
                'dias_no_laborados' => 0,
                'minutos_de_tardanzas' => 0,
                'bonificacion' => 0,
                'descuento' => 0,
            ]);
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Estado actualizado con éxito',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);

        $this->emit('refreshComponent');
    }
}

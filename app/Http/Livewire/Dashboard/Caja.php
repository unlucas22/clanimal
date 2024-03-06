<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{CashRegister, User, Casher};
use Illuminate\Support\Facades\{Auth, Log};

class Caja extends Component
{
    use HasTable;

    public $title = 'Caja';

    public $columns = [
        'id' => 'ID',
        'formatted_en_caja' => 'En caja',
        'formatted_total_efectivo' => 'Efectivo',
        'formatted_total_tarjeta' => 'Tarjeta',
        'formatted_total_virtual' => 'Tarjeta Virtual',
        'formatted_total_credito' => 'Créditos',
        'formatted_status' => 'Estado',
        'closed_at' => 'Cerrado',
        'created_at' => 'Abierto',
    ];

    protected $listeners = ['refreshParent' => '$refresh', 'cerrarCaja'];

    public $search = '';

    public function mount()
    {
        /* verificar si el colaborador está asignado a una caja */
        $caja = Casher::where('user_id', Auth::user()->id)->first();

        if($caja == null)
        {
            return redirect('/');
        }

        $this->title = 'Caja N°'.$caja->id;
        $this->description = Auth::user()->name;
    }

    public function getItems()
    {
        $query = CashRegister::query();

        $query->where('casher_id', Auth::user()->id);

        /*if($this->search != '')
        {
            $query->where('name', 'like', '%' . $this->search . '%');
        }*/

        //$query->with(['cashers']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($this->rows);
    }

    public function render()
    {
        $this->table = 'cash_registers';

        $this->relationships = [
            
        ];

        $this->updated_at = false;
        $this->created_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItems(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'caja',
            'head_name' => 'caja',
        ]);
    }

    public function cerrarCaja()
    {
        try {

            CashRegister::where('casher_id', Auth::user()->cashers[0]->id)
                ->where('closed_at', null)
            ->update([
                'status' => 'validacion',
                'closed_at' => now(),
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Caja cerrado con éxito.',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
            
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

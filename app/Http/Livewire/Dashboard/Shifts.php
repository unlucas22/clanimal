<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Shift;
use Illuminate\Support\Facades\Log;

class Shifts extends Component
{
    use HasTable;

    protected $listeners = ['cancel' => 'cancelShift'];

    public $title = 'Turnos';

    public $filters = [];

    public $columns = [
        'id' => 'ID',
        'appointment' => 'Cita',
    ];

    public function render()
    {
        $items = Shift::with(['users', 'pets', 'services'])->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'shifts';

        $this->relationships = [
            'Mascota',
            'Cliente',
            'Tipo de Servicio',
            'Estado',
        ];

        $this->created_at = false;
        $this->updated_at = false;

        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'turno',
            'head_name' => 'turno',
            'description' => 'Programación de Citas'
        ]);
    }

    public function cancelShift($item_id)
    {
        try {
            
            Shift::where('id', $item_id)->update([
                'status' => 'cancelado',
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Turno actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

        } catch (\Exception $e) {

            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        }
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Finance;

class FinanzasIngresos extends Component
{
    use HasTable;

    public $title = 'Ingresos';

    public $description = 'Reporte de dinero enviado por gerentes de tienda';

    public $columns = [
        'id' => 'ID',
    ];

    protected $listeners = ['deleteItem' => 'delete', 'refreshParent' => '$refresh'];
    public $search = '';

    public function delete($item_id)
    {
        $this->deleteItem($item_id);

        $this->emit('refreshComponent');
    }

    public function getItemsFromFinance()
    {
        $query = Finance::query();

        if($this->search != '')
        {
            $query->where('status', 'like', '%' . $this->search . '%')
                ->orWhere('reported_at', 'like', '%' . $this->search . '%');
        }

        $query->with('users');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);;
    }

    public function render()
    {
        $this->table = 'finances';

        $this->relationships = [
            'Fecha de reporte',
            'Fecha de validación',
            'Gerente de Tienda',
            'Local',
            ' Monto Tarjeta',
            'Monto Efectivo',
            'Estado',
        ];

        $this->relationship_name = 'finanzas-ingresos';

        $this->created_at = false;
        $this->updated_at = false;
        $this->can_delete = false;

        return view('livewire.dashboard.table', [
            'items' => $this->getItemsFromFinance(),
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'finanzas-ingresos',
            //'head_name' => 'product-brand',
        ]);
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Client;

class Clients extends Component
{
    use HasTable;

    public $title = 'Clientes';

    public $filters = [
        'name' => '',
    ];

    public $columns = [
        'id' => 'ID',
        'name' => 'Nombres y Apellidos',
        'dni' => 'DNI',
        //'email' => 'Correo electronico',
        'phone' => 'Teléfono',
        'address' => 'Dirección'
    ];

    public $name = '';
    public $email = '';
    public $phone = '';

    public function render()
    {
        $items = Client::with(['users', 'reports'])->withCount('pets')->when($this->name !== '', function($qry) {
            $qry->where('name', 'like', '%'.$this->name.'%');
        })->when($this->email !== '', function($qry) {
            $qry->where('email', 'like', '%'.$this->email.'%');
        })->when($this->phone !== '', function($qry) {
            $qry->where('phone', 'like', '%'.$this->phone.'%');
        })->orderBy('updated_at', 'desc')->paginate($this->rows);

        $this->table = 'clients';

        $this->relationships = [
            // 'Mascotas en total',
            // 'Promedio de visitas', Va en analytics
            // 'Monto gastado',
            'Calificación',
            // 'Registrado por',
        ];

        $this->can_delete = false;

        $this->updated_at = false;

        return view('livewire.dashboard.table', [
            'items' => $items,
            'rows_count' => $this->rows_count,
            'columns' => $this->columns,
            'columns_count' => $this->getColumnsCount($this->columns),
            'action_name' => 'client',
            'head_name' => 'client',
        ]);
    }
}

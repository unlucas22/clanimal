<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\Client;

class Clients extends Component
{
    use HasTable;

    public $title = 'Clientes y Mascotas';

    public $filters = [
        'name' => 'nombre',
        'email' => 'correo electronico',
        'phone' => 'número de celular'
    ];

    public $columns = [
        'name' => 'Nombre completo',
        'email' => 'Correo electronico',
        'phone' => 'Número de celular',
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
            'Mascotas en total',
            // 'Promedio de visitas', Va en analytics
            'Monto gastado',
            'Clasificación',
            // 'Registrado por',
        ];

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

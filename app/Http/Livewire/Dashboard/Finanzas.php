<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{CashRegister, User, Casher, Finance};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;

class Finanzas extends Component
{
    public $listeners = ['refreshParent' => '$refresh'];

    public $searchIngreso = '';

    public function getItemsFromFinance()
    {
        $query = Finance::query();

        if($this->searchIngreso != '')
        {
            $query->where('status', 'like', '%' . $this->searchIngreso . '%')
                ->orWhere('reported_at', 'like', '%' . $this->searchIngreso . '%');
        }

        $query->with('users');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);;
    }

    public function getIngresosDelDia()
    {
        $total = 0;

        $ingresos = Finance::where('status', 'completado')->whereDate('reported_at', Carbon::today())->get();

        foreach ($ingresos as $ingreso)
        {
            $total += $ingreso->total; 
        }

        return $total;
    }

    public function getSalidasDelDia()
    {
        $total = 0;

        return $total;
    }


    public function getEnBancoDelDia()
    {
        $total = 0;

        return $total;
    }

    public function render()
    {
        return view('livewire.dashboard.finanzas', [
            'items' => $this->getItemsFromFinance(),
            'salidas' => $this->getItemsFromFinance(),
            'ingresos_del_dia' => 0,//$this->getIngresosDelDia(),
            'salidas_del_dia' => 0, $this->getSalidasDelDia(),
            'en_banco_del_dia' => $this->getEnBancoDelDia()
        ]);
    }
}

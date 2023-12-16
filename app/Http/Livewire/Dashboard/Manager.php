<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{CashRegister, User, Casher, Finance};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;

class Manager extends Component
{
    public $listeners = ['refreshParent' => '$refresh'];

    public $searchIngreso = '';

    public $searchSalida = '';

    public function getItemsFromCashRegister()
    {
        $query = CashRegister::query();

        if($this->searchIngreso != '')
        {
            $query->where('status', 'like', '%' . $this->searchIngreso . '%')
                ->orWhere('validated_at', 'like', '%' . $this->searchIngreso . '%');
        }

        $query->with('cashers');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);;
    }

    public function getItemsFromFinance()
    {
        $query = Finance::query();

        if($this->searchSalida != '')
        {
            $query->where('status', 'like', '%' . $this->searchSalida . '%')
                ->orWhere('reported_at', 'like', '%' . $this->searchSalida . '%');
        }

        $query->with('users');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);;
    }

    public function getIngresosDelDia()
    {
        $total = 0;

        $ingresos = CashRegister::where('status', 'completado')->whereDate('validated_at', Carbon::today())->get();

        foreach ($ingresos as $ingreso)
        {
            $total += $ingreso->total; 
        }

        return $total;
    }

    public function getSalidasDelDia()
    {
        $total = 0;

        $salidas = Finance::where('status', 'completado')->whereDate('reported_at', Carbon::today())->get();

        foreach ($salidas as $salida)
        {
            $total += $salida->total; 
        }

        return $total;
    }


    public function getEnCajaDelDia()
    {
        $total = 0;

        $ingresos = CashRegister::where('status', 'completado')->whereDate('validated_at', Carbon::today())->get();

        foreach ($ingresos as $ingreso)
        {
            $total += $ingreso->en_caja; 
        }

        return $total;
    }

    public function render()
    {
        return view('livewire.dashboard.manager', [
            'ingresos' => $this->getItemsFromCashRegister(),
            'salidas' => $this->getItemsFromFinance(),
            'ingresos_del_dia' => $this->getIngresosDelDia(),
            'salidas_del_dia' => $this->getSalidasDelDia(),
            'en_caja_del_dia' => $this->getEnCajaDelDia()
        ]);
    }
}

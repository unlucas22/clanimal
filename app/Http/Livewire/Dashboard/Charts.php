<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\{User, Client};

class Charts extends Component
{
    public $porcentaje_cambio;

    public function render()
    {
        return view('livewire.dashboard.charts', [
            'users_data' => $this->calcularPorcentajeCambio(),
            'users_count' => Client::count(),
        ]);
    }

    /**
     * Calcular porcentaje de usuarios registrados respecto al mes actual
     * */
    public function calcularPorcentajeCambio()
    {
        $mes_actual = now()->format('m');
        $anio_actual = now()->format('Y');

        $mes_pasado = now()->subMonth()->format('m');
        $anio_pasado = now()->subMonth()->format('Y');

        $porcentaje_cambio = 0;

        $clientes_mes_actual = Client::whereYear('created_at', $anio_actual)
            ->whereMonth('created_at', $mes_actual)
            ->count();

        $clientes_mes_pasado = Client::whereYear('created_at', $anio_pasado)
            ->whereMonth('created_at', $mes_pasado)
            ->count();

        if ($clientes_mes_pasado > 0)
        {
            $porcentaje_cambio = (($clientes_mes_actual - $clientes_mes_pasado) / $clientes_mes_pasado) * 100;
        }

        $this->porcentaje_cambio = $porcentaje_cambio.'%';

        return json_encode([
            'clientes_mes_actual' => $clientes_mes_actual,
            'clientes_mes_pasado' => $clientes_mes_pasado,
            'porcentaje_cambio' => $porcentaje_cambio,
            'mes_actual' => $mes_actual,
            'mes_pasado' => $mes_pasado,
        ]);
    }
}

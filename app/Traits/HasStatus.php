<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

/* Lista ordenada de todos los estados posibles para los Turnos y Recepción */
trait HasStatus {

	/* Todos los estados */
	public $all_status = [
		'confirmado', 'retrasado', 'programado', 'reprogramado' ,'cancelado',
		'en atención', 'listo para retiro', 'terminado'
	];

	/* Lista especifica para el modulo de recepción */
	public $status_lista_de_espera = ['confirmado', 'retrasado', 'programado', 'reprogramado', 'cancelado'];
	public $status_notificaciones = ['en atención', 'listo para retiro', 'terminado'];
}
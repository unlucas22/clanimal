<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

/* Obtiene los datos por dni */
trait Reniec {

	public $apiUrl = "https://dniruc.apisperu.com/api/v1/dni/";

    public function consultarDNI($dni)
    {
        $url = $this->apiUrl . "{$dni}?token=" . Config::get('app.reniec');

        // Inicializar cURL
        $ch = curl_init();

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Realizar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hubo algún error en la solicitud
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        // Cerrar la sesión cURL
        curl_close($ch);

        // Decodificar el JSON
        $data = json_decode($response, true);

        // Retornar los datos obtenidos
        return $data;
    }
}
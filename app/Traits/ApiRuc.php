<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

/* Obtiene los datos por dni */
trait ApiRuc {

    public function consultarRUC($ruc)
    {
    	// 20131257750
        $url = Config::get('app.ruc') . "?ruc=" . $ruc;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        // Verificar si hubo algún error en la solicitud
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $data = json_decode($response, true);

        return $data;
    }
}
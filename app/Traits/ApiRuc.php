<?php

namespace App\Traits;

/* Obtiene los datos por dni */
trait ApiRuc {

	public $apiRucUrl = "https://mesadepartesdigital.midagri.gob.pe/PersonaJuridica/CrearCuenta/GetRuc";

    public function consultarRUC($ruc)
    {
    	// 20131257750
        $url = $this->apiRucUrl . "?ruc=" . $ruc;

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
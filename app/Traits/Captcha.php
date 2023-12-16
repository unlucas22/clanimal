<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait Captcha {

    /* Reemplazar en .env */
    protected $secret_key;

    /**
     * Validacion del Captcha
     * */
    public function captchaValidation($g_response)
    {
        if(!isset($g_response) || empty($g_response))
        {
            // 'Captcha sin resolver. Vuelva a intentarlo'
            return false;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=".Config::get('app.captcha_secret_key')."&response=".$g_response);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $grecaptcha = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if($grecaptcha['success'] === false)
        {
            // Captcha invalido: vuelva a intentarlo
            return false;
        }

        return true;
    }
}
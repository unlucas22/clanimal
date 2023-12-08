<?php

namespace App\Traits;

trait Captcha {

    /* Reemplazar en .env */
    public $public_key = '6Lf391shAAAAAEij46zNjIHm2O8e6oYXPP56Llzk';
    protected $secret_key = '6Lf391shAAAAABeT08kWBOSMKFtTRoon_2dh1gz5';

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

        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=".$this->secret_key."&response=".$g_response);

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
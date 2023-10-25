<?php

namespace App\Traits;

trait Captcha {

    public $public_key = '6Lf391shAAAAAEij46zNjIHm2O8e6oYXPP56Llzk';
    protected $secret_key = '6Lf391shAAAAABeT08kWBOSMKFtTRoon_2dh1gz5';

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

    //        ddd([$grecaptcha, curl_exec($ch)]);
        
        curl_close($ch);

        if($grecaptcha['success'] === false)
        {
            // sprintf('Captcha invalido: %s, vuelva a intentarlo', $grecaptcha['error-codes'][0])
            return false;
        }


        return true;
    }
}
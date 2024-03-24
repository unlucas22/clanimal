<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\{Session, Auth};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ], [
                'email.required' => 'El campo correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
                'password.required' => 'El campo contraseña es obligatorio.',
                'g-recaptcha-response.required' => 'Por favor, completa el ReCaptcha.',
                'g-recaptcha-response.captcha' => 'El ReCaptcha es inválido. Por favor, inténtalo de nuevo.',
            ]);

            $credentials = $request->only('email', 'password');

            if (! auth()->attempt($credentials))
            {
                return false;
            }

            return Auth::user();

            /*
            $data = [
                'secret' => config('app.captcha_secret_key'),
                'response' => $request['g-recaptcha-response'],
            ];

            $ch = curl_init();

            // Configura las opciones de la solicitud
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Realiza la solicitud y obtén la respuesta
            $response = curl_exec($ch);

            // Verifica si la solicitud fue exitosa y si la respuesta es válida
            if ($response !== false)
            {
                $data = json_decode($response, true);

                ddd($data);

                // El ReCaptcha es válido, continuar con el proceso de autenticación o lo que sea necesario
                if ($data['success'])
                {
                    return $user;
                }
                else
                {
                    return session()->flash('error', 'Google thinks you are a bot, please refresh and try again');
                }
            } else {
                ddd($ch);
            }
            */
        });
    }
}

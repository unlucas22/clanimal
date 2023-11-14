<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, User, Control, Reason};
use Illuminate\Support\Facades\{Auth, Cookie};
use Illuminate\Support\Facades\Log;
use BrowserDetect;
use Hashids;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function showClient(Request $req)
    {
        $id = Hashids::decode($req->hashid);

        return view('show.client', [
           'id' => $id,
        ]);
    }

    /**
     * Verificacion de qr
     * 
     * @param Request $req hashid|date
     * */
    public function qrVerification(Request $req)
    {
        try 
        {
            $user = User::where('id', Hashids::decode($req->hashid))->firstOrFail();

            /* validacion por hora o bien lo puedo hacer por minutos */
            // $date = Hashids::decode($req->date);
            
            /*if(now()->format('H') != $date){
                Cookie::forget('qr_validation');

                return redirect('login');
            }
            $now = (Carbon::parse($date.':'.now()->format('i:s')))->format('Y-m-d H:i:s');*/

            /* Que no se registre dos veces en la misma día */
            if(!Cookie::has('qr_validation'))
            {
                $device = 'Navegador: '.BrowserDetect::browserName().' - SO: '.BrowserDetect::platformName().' - Dispositivo: '.BrowserDetect::deviceFamily();

                $control = Control::create([
                    'user_id' => $user->id,
                    'ip' => $req->ipinfo->ip,
                    'hostname' => $req->ipinfo->hostname ?? 'local',
                    'city' => $req->ipinfo->city ?? 'local',
                    'device' => $device,
                    'reason_id' => $req->motivo,
                    'company_id' => $req->company,
                    'date' => now(),
                ]);

                /* cookie con 25 minutos de expiracion */
                Cookie::queue('qr_validation', $user->hashid, 25);
            }

            return redirect( route('perfil.colaborador') );
        }
        catch (\Exception $e)
        {

            ddd($req);
            Log::error($e->getMessage());

            Cookie::forget('qr_validation');

            return redirect('login');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, User, Control};
use Illuminate\Support\Facades\{Auth, Cookie};
use BrowserDetect;
use Hashids;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function showClient(Request $req)
    {
        $client = Client::with(['pets', 'users'])->where('id', Hashids::decode($req->hashid))->firstOrFail();

        return view('livewire.dashboard.show.client', [
            'client' => $client,
            'pets' => $client->pets,
            'pet_photos_count' => $client->pets->count()
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

            /* en caso de que requiera una validacion por hora */
            // $date = Hashids::decode($req->date);
            // $now = now()->format('H');

            /* Que no se registre dos veces en la misma día */
            if(!Control::whereDate('created_at', Carbon::today())->where('confirmed', false)->count() && !Cookie::has('qr_validation'))
            {
                $device = 'Navegador: '.BrowserDetect::browserName().' - SO: '.BrowserDetect::platformName().' - Dispositivo: '.BrowserDetect::deviceFamily();

                $control = Control::create([
                    'user_id' => $user->id,
                    'ip' => $req->ipinfo->ip,
                    'hostname' => $req->ipinfo->hostname ?? 'local',
                    'city' => $req->ipinfo->city ?? 'local',
                    'device' => $device,
                ]);

                /* 12 horas de expiracion */
                Cookie::queue('qr_validation', $control->hashid, 60*12);
            }

            return redirect('login');
        }
        catch (\Exception $e)
        {
            \Log::error($e->getMessage());

            Cookie::forget('qr_validation');

            return redirect('login');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Pet, PetPhoto, Service, Shift, Reception};
use Illuminate\Support\Facades\{Log, Auth};
use Carbon\Carbon;
use Hashids;
use DB;

class PetController extends Controller
{
    /* Limite de imagenes para las mascotas */
    public $limit = 3;

    /**
     * Cargar Imagenes para mascotas
     * 
     * @param Request $req hashid de la mascota
     * */
    public function createPetImages(Request $req)
    {
        $pet = Pet::where('id', Hashids::decode($req->hashid))->firstOrFail();

        return view('livewire.dashboard.create.pet-images', [
            'pet' => $pet,
            'limit' => $this->limit,
        ]);
    }

    public function storePet(Request $req)
    {
        ddd($req);
    }
    
    /**
     * Obtener todos los turnos del día o de la fecha seleccionada
     * 
     * @param \Request $req (fecha, csrf_token, ipinfo)
     * 
     * @return \Response turnos
     * */
    public function getShifts(Request $req)
    {
        /* Eliminar la información de la zona horaria (desde 'GMT' en adelante) */
        $fecha = substr($req->fecha, 0, strpos($req->fecha, 'GMT') - 1);

        $shifts = Shift::with(['pets', 'services'])->when($fecha !== null, function($qry) use($fecha) {
            $qry->whereDate('appointment', (Carbon::parse($fecha))->format('Y-m-d') );
        }, function($qry) {
            $qry->whereDate('appointment', Carbon::today());
        })->get();

        $json = [];

        foreach ($shifts as $shift) {
            $json[] = [
                'hora' => $shift->appointment->format('H:i'),
                'pet_name' => $shift->pets->name,
                'service' => $shift->services->name,
            ];
        }
        return response()->json($json);
    }

    public function createReception(Request $req)
    {
        $pet = null;
        $pets = Pet::get();
        
        if($req->hashid !== null)
        {
            $pet = Pet::where('id', Hashids::decode($req->hashid))->firstOrFail();
        }

        $shifts = Shift::with(['pets', 'services'])->whereDate('appointment', Carbon::today())->get();
        
        return view('livewire.dashboard.create.reception', [
            'pet' => $pet,
            'pets' => $pets,
            'shifts' => $shifts,
            'services' => Service::get(),
        ]);
    }

    public function storeReception(Request $req)
    {
        try {
            
            $req->validate([
                'pet_id' => 'required',
                'service_id' => 'required',
                'hora' => 'required',
            ]);
            
            /* Se formatea la fecha */
            $entry = Carbon::parse(Carbon::now()->format('Y-m-d').' '.$req->hora);

            $shift = Reception::create([
                'user_id' => Auth::user()->id,
                'pet_id' => $req->pet_id,
                'service_id' => $req->service_id,
                'entry' => $entry,
                'shift_id' => $req->shift_id == 0 ? null : $req->shift_id,
            ]);

            return redirect(route('dashboard.receptions'));
        
        } catch (\Exception $e) {

            ddd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function storeShift(Request $req)
    {
        try {
            
            $req->validate([
                'pet_id' => 'required',
                'service_id' => 'required',
                'hora' => 'required',
                'fecha' => 'required',
            ]);

            /* Se formatea la fecha */
            $appointment = Carbon::parse($req->fecha.' '.$req->hora);

            $shift = Shift::create([
                'pet_id' => $req->pet_id,
                'service_id' => $req->service_id,
                'user_id' => Auth::user()->id,
                'appointment' => $appointment,
            ]);

            return redirect(route('dashboard.shifts'));
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }
    }
    
    /**
     * Carga e inserta las imagenes en la DB
     * 
     * @param Request $req
     * @param \App\Models\Pet $pet_id
     *  
     * */
    public function storePetImages(Request $req)
    {
        DB::beginTransaction();

        try
        {

            $image = null;

            for ($i=0; $i < $this->limit; $i++)
            { 
                
                $input = "images_{$i}";

                if($req->file($input) == null)
                {
                    continue;
                }

                PetPhoto::create([
                    'pet_id' => $req->pet_id,
                    'path' => $this->storeImage($req, $input),
                ]);
            }

            DB::commit();

            $pet = Pet::with('clients')->where('id', $req->pet_id)->first();

            /* añadir GET con el id */
            return redirect()->route('dashboard.show.client', [
                'hashid' => $pet->clients->hashid,
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollback();

            ddd($e->getMessage());
        }
    }

    /**
     * Guarda los archivos con un filenime unico
     * Y los inserta en storage/pets
     * 
     * @param Request $req
     * @param \App\Models\PetPhoto $pet_id
     *  
     * @return \App\Models\Image
     * 
     * */
    protected function storeImage($req, $input)
    {
        $req->validate([
            $input => 'mimes:jpg,png,jpeg'
        ]);

        $fileName = uniqid() . '-' .$req->file($input)->getClientOriginalName();

        $path = $req->file($input)->storeAs('uploads', $fileName, 'public');

        return $path;
    }
}

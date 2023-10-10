<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Pet, PetPhoto};
use Hashids;
use DB;

class PetController extends Controller
{
    public $limit = 3;

    public function createPetImages(Request $req)
    {
        $pet = Pet::where('id', Hashids::decode($req->hashid))->firstOrFail();
        $this->limit = $req->limit ?? 3; 

        return view('livewire.dashboard.create.pet-images', [
            'pet' => $pet,
            'limit' => $this->limit,
        ]);
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

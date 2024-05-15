<?php

namespace App\Traits;

use Illuminate\Support\Facades\{Auth, Log};
use Illuminate\Support\Str;
use App\Models\Authorization;
use App\Jobs\SendAuthorizationJob;
use DB;

/* Obtiene los datos por dni */
trait SetAuthorization {

    // enviar email
    public function makeAuthorization($product)
    {
        DB::beginTransaction();

        try 
        {
            $code = $this->generateRandomCode();

            // se crea un nuevo codigo
            Authorization::where('user_id', Auth::user()->id)->whereNotNull('validated_at')->delete();

            Authorization::create([
                'user_id' => Auth::user()->id,
                'code' => $code,
            ]);

            SendAuthorizationJob::dispatch($code, Auth::user()->name, $product);

            DB::commit();
            
            return true;
        } 
        catch (Exception $e) 
        {
            DB::rollback();

            Log::error($e);
            return false;
        }

    }

    public function generateRandomCode()
    {
        return Str::random(10);
    }

    public function validateAuthorization($code)
    {
        Log::info('desde validate: '.$code);

        try
        {
            $a = Authorization::where('user_id', Auth::user()->id)->whereNull('validated_at')->first();

            Log::info('codigo que tiene que introducirse: '.$a->code);

            if($a->code != $code)
            {
                // Authorization::where('user_id', Auth::user()->id)->delete();
                return false;
            }

            $a->update([
                'validated_at' => now(),
            ]);

            return true;
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return false;
        }
    }

}
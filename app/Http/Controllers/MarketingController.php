<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MarketingTemplate, MarketingCampaign, MarketingTracking};
use Illuminate\Support\Facades\{Auth, Log};
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

class MarketingController extends Controller
{
    public function storeTemplate(Request $req)
    {
        DB::beginTransaction();

        try {

            $photo_path = null;

            $input = "image";

            if($req->file($input) != null)
            {
                $photo_path = $this->storeImage($req, $input);
            }

            MarketingTemplate::create([
                'name' => $req->name,
                'content' => $req->content,
                'button_text' => $req->button_text,
                'button_url' => $req->button_url,
                'image' => $photo_path,
            ]);

            DB::commit();

            return redirect()->route('dashboard.marketing-templates');

        } catch (\Exception $e) {

            DB::rollback();

            \Log::error($e->getMessage());

            return back();
        }
    }

    public function updateTemplate(Request $req)
    {
        DB::beginTransaction();

        try {

            $photo_path = null;

            $input = "image";

            if($req->file($input) != null)
            {
                $photo_path = $this->storeImage($req, $input);

                MarketingTemplate::where('id', $req->template_id)->update([
                    'image' => $photo_path,
                ]);
            }

            MarketingTemplate::where('id', $req->template_id)->update([
                'name' => $req->name,
                'content' => $req->content,
                'button_text' => $req->button_text,
                'button_url' => $req->button_url,
            ]);

            DB::commit();

            return redirect()->route('dashboard.marketing-templates');

        } catch (\Exception $e) {

            DB::rollback();

            \Log::error($e->getMessage());

            return back();
        }
    }

    /**
     * Guarda los archivos con un filename unico
     * Y los inserta en storage/pets
     * 
     * @param Request $req
     *  
     * @return \App\Models\Image
     * 
     * */
    protected function storeImage($req, $input)
    {
        $req->validate([
            $input => 'mimes:jpg,png,jpeg'
        ]);

        try {
            $fileName = uniqid() .'-emails.' . $req->file($input)->getClientOriginalExtension();

            $req->file($input)->move(public_path().'/img/emails/', $fileName);
        
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $fileName;
    }
}

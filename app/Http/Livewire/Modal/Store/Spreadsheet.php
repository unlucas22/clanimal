<?php

namespace App\Http\Livewire\Modal\Store;

use Carbon\Carbon;
use LivewireUI\Modal\ModalComponent;
use App\Models\{UserForSpreadsheet, User};
use Illuminate\Support\Facades\{Log, Auth};
use DB;

class Spreadsheet extends ModalComponent
{
    public $fecha;

    public function render()
    {
        return view('livewire.modal.store.spreadsheet');
    }

    public function submit()
    {
        DB::beginTransaction();

        try {

            $fecha = Carbon::parse($this->fecha.Carbon::now()->format('-d H:i:s'));

            $spreadsheet = \App\Models\Spreadsheet::create([
                'fecha' => $fecha,
            ]);

            $users = User::where('deleted_at', null)->where('active', true)->get();

            foreach ($users as $user)
            {
                UserForSpreadsheet::create([
                    'user_id' => $user->id,
                    'spreadsheet_id' => $spreadsheet->id,
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard.show.rrhh-spreadsheet', [
                'hashid' => $spreadsheet->hashid
            ]);

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            DB::rollback();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

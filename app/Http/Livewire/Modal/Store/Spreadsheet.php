<?php

namespace App\Http\Livewire\Modal\Store;

use Carbon\Carbon;
use LivewireUI\Modal\ModalComponent;
use App\Models\{UserForSpreadsheet, User};
use Illuminate\Support\Facades\{Log, Auth};
use Illuminate\Validation\Rule;
use DB;

class Spreadsheet extends ModalComponent
{
    public $year_selected;
    public $month_selected;

    public $months;
    public $years;

    public function mount()
    {
        // Llena las propiedades con datos, por ejemplo, para los últimos 5 años y los 12 meses
        $this->years = range(date('Y'), date('Y') - 5, -1);
        $this->months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $this->month_selected = 1;
        $this->year_selected = now()->format('Y');
    }

    public function render()
    {
        return view('livewire.modal.store.spreadsheet');
    }

    public function submit()
    {
        if(\App\Models\Spreadsheet::whereYear('fecha', $this->year_selected)
            ->whereMonth('fecha', $this->month_selected)->count())
        {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Ya existe una planilla con la fecha',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            return false;
        }

        DB::beginTransaction();


        try {
            $fecha = Carbon::parse(Carbon::now()->format('d').'-'.$this->month_selected.'-'.$this->year_selected.Carbon::now()->format('H:i:s'));

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

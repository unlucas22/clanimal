<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\HasTable;
use App\Models\{Transfer, ProductForStore, ProductForTransfer};
use Illuminate\Support\Facades\{Auth, Log};
use DB;

class Tienda extends Component
{
    use HasTable;

    public $search = '';

    public $listeners = ['refreshParent' => '$refresh', 'marcarComoRecibido'];

    public function getItemsFromTransfer()
    {
        $query = Transfer::query();

        /*if($this->search != '')
        {
            $query->where('factura', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%');
        }*/

        $query->where('company_id', Auth::user()->company_id);

        $query->with(['users', 'product_for_transfers']);

        $query->withCount('product_for_transfers');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);
    }

    public function getItemsFromProductForStore()
    {
        $query = ProductForStore::query();

        if($this->search != '')
        {
            $query->where('fecha', 'like', '%' . $this->search . '%');
        }

        $query->where('company_id', Auth::user()->company_id);

        $query->with(['products', 'users', 'companies']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.productos-para-tienda', [
            'products' => $this->getItemsFromProductForStore(),
            'notifications' => $this->getItemsFromTransfer(),
        ]);
    }

    public function marcarComoRecibido($transfer_id)
    {
        DB::beginTransaction();

        try {
            
            Transfer::where('id', $transfer_id)->update([
                'status' => 'completado',
                'fecha_recepcion' => now(),
            ]);

            $transfers = ProductForTransfer::where('transfer_id', $transfer_id)->get();

            foreach ($transfers as $transfer)
            {
                ProductForStore::create([
                    'user_id' => Auth::user()->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $transfer->product_id,
                    'stock' => $transfer->stock,
                    'fecha' => now(),
                ]);
            }

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Estado actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            DB::commit();

        } catch (\Exception $e) {

            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);

            DB::rollback();
        }
    }
}

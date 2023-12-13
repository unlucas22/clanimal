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

    public $searchStore = '';

    public $searchTransfer = '';

    public $listeners = ['refreshParent' => '$refresh', 'marcarComoRecibido'];

    /* Products */
    public function getItemsFromNotification()
    {
        $query = ProductForStore::query();

        if($this->searchStore != '')
        {
            $query->whereHas('products', function($q){
                $q->where('name', 'like', '%' . $this->searchStore . '%');
            })->orWhere('fecha', 'like', '%' . $this->searchStore . '%')->orWhere('id', 'like', '%' . $this->searchStore . '%');
        }

        $query->where('company_id', Auth::user()->company_id);

        $query->with(['products', 'users', 'companies']);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10, '*', 'paginationStore');
    }

    /* Transferencias */
    public function getItemsFromTransfer()
    {
        $query = Transfer::query();
        
        if($this->searchTransfer != '')
        {
            //$query->where('fecha_recepcion', 'like', '%' . $this->searchTransfer . '%')->orWhere('fecha_envio', 'like', '%' . $this->searchTransfer . '%')->orWhere('id', 'like', '%' . $this->searchTransfer . '%')->where('company_id', Auth::user()->company_id);
        }

        $query->where('company_id', Auth::user()->company_id);

        $query->with(['users', 'product_for_transfers']);

        $query->withCount('product_for_transfers');

        $query->orderBy('updated_at', 'desc');

        return $query->paginate(10, '*', 'paginationTransfer');
    }


    public function render()
    {
        return view('livewire.dashboard.productos-para-tienda', [
            'products' => $this->getItemsFromNotification(),
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

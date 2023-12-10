<?php

namespace App\Http\Livewire\Modal\Store;

use LivewireUI\Modal\ModalComponent;
use App\Models\{ProductForStore, Transfer, Product};
use Illuminate\Support\Facades\{Log, Auth};
use DB;

class Tienda extends ModalComponent
{
    public $product_id;

    public $stock = 1;
    public $max_stock = 1;

    public function mount()
    {
        $product = Product::first();

        $this->product_id = $product->id;
        $this->max_stock = $product->stock_total;
    }

    public function updatedProductId($product_id)
    {
        $product = Product::where('id', $product_id)->first();

        $this->max_stock = $product->stock_total;
    }

    public function render()
    {
        return view('livewire.modal.store.tienda', [
            'products' => Product::get(),
        ]);
    }


    public function submit()
    {
        DB::beginTransaction();

        try {

            $stock = $this->stock;

            $product = Product::with(['product_details'])->where('id', $this->product_id)->first();

            ProductForStore::create([
                'company_id' => Auth::user()->company_id,
                'product_id' => $this->product_id,
                'user_id' => Auth::user()->id,
                'stock' => $this->stock,
            ]);

            /**
            foreach ($product->product_details as $product_details)
            {
                ProductDetail::where('id', $product_details->id)->update([
                    'stock' => $product_details->amount - $stock,
                ]);
            }
            **/

            $this->emit('refreshParent');

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Producto para tienda registrado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

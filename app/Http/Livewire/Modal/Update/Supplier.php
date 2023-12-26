<?php

namespace App\Http\Livewire\Modal\Update;

use LivewireUI\Modal\ModalComponent;
use App\Models\{Casher, User, Company};
use Illuminate\Support\Facades\Log;

class Supplier extends ModalComponent
{
    public $item_id;

    public $name;
    public $ruc;
    public $phone;
    public $address;

    public $cuenta_bancaria;
    public $banco;
    public $beneficiario;
    public $moneda;

    public $rules = [
        'name' => 'required|string|max:50',
        'ruc' => 'max:12',
        'phone' => 'required|string|max:30',
        'address' => 'string|max:50',
    ];

    public function mount($item_id)
    {
        $model = \App\Models\Supplier::where('id', $item_id)->firstOrFail();

        $this->name = $model->name;
        $this->address = $model->address;
        $this->phone = $model->phone;
        $this->ruc = $model->ruc;

        $this->cuenta_bancaria = $model->cuenta_bancaria;
        $this->banco = $model->banco;
        $this->beneficiario = $model->beneficiario;
        $this->moneda = $model->moneda;
    }

    public function render()
    {
        return view('livewire.modal.update.supplier');
    }

    public function save()
    {
        $this->validate();

        try {
            
            \App\Models\Supplier::where('id', $this->item_id)->update([
                'name' => $this->name,
                'ruc' => $this->ruc,
                'address' => $this->address,
                'phone' => $this->phone,
                'cuenta_bancaria' => $this->cuenta_bancaria,
                'banco'  => $this->banco,
                'beneficiario'  => $this->beneficiario,
                'moneda'  => $this->moneda,
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Proveedor actualizado con éxito',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);

            $this->closeModal();

            return redirect()->route('dashboard.suppliers');

        } catch (\Exception $e) {
            Log::info($e->getMessage());

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Hubo un error: '.$e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }
    }
}

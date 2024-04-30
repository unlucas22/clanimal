<?php

namespace App\Http\Livewire\Dashboard\Show;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\{ProductBrand, ProductCategory, ProductPresentation, ProductDetail, Authorization};
use Illuminate\Support\Facades\{Log, Auth};
use App\Traits\SetAuthorization;

class Product extends Component
{
    use SetAuthorization;

    /*** Datos del Producto ***/
    public $product_presentation_id;
    public $name;
    public $palabras_clave;
    public $barcode;
    public $alerta_stock;

    /* Stock */
    public $amount;
    /* Stock por Presentacion */
    public $amount_presentation;

    /* ¿Precio compra en desuso? */
    public $precio_compra;

    /*** Datos de SubProductos ***/
    /* Se hace un foreach por cada id en el Controlador */
    public $product_details;

    public $discount_details = [];

    public $precio_venta_details = [];

    public $precio_venta_con_igv_details = [];

    public $product_presentation_details_id = [];

    public $product = [];

    public $precio_venta_total = [];

    /* Datalist */
    public $product_brands;
    public $product_categories;

    public $listeners = ['getBarcode', 'refreshParent', 'refreshComponent' => '$refresh', 'agregarOferta', 'setPrecioOferta', 'enviarEmail', 'validarAutorizacion'];

    public $product_ofertas = [
        // 'product_detail_id',
        // 'precio_total',
        // 'fecha_inicio',
        // 'fecha_final',
    ];

    public function calcularGanancia()
    {
        foreach ($this->product_ofertas as $oferta)
        {
            if($oferta['precio_total'] != null && $oferta['precio_total'] > 0)
            {
                $ganancia = (($this->precio_venta_details[$oferta['product_detail_id']] - $oferta['precio_total']) / $oferta['precio_total']) * 100;

                if($ganancia > 40)
                {
                    return $oferta;
                }
            }
            else
            {
                // incompleto
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Debes completar todos los campos antes de continuar.',
                    'icon' => 'error',
                    'iconColor' => 'red',
                ]);
                break;
            }
        }
        
        // no enviar email
        return false;
    }

    /**
     * Enviar el email de autorizacion a los gerentes
     * agregar el filtro de tienda
     * */
    public function enviarEmail()
    {
        try
        {
            $oferta = $this->calcularGanancia();

            if($oferta == false)
            {
                $this->emit('respuestaEmail', false);
                return;
            }

            $pp = ProductPresentation::select('name')->where('id', $this->product_presentation_details_id[$oferta['product_detail_id']])->first();

            // descripcion de la unidad
            $product = $pp->name.'. Precio Venta con IGV: S/ '.$this->precio_venta_details[$oferta['product_detail_id']].'. Precio Total: S/ '.$oferta['precio_total'];

            $this->makeAuthorization($product);
        } 
        catch (Exception $e) 
        {
            Log::error($e);    
        }
    }

    public function validarAutorizacion($value)
    {
        Log::info($value);
        if($this->validateAuthorization($value))
        {
            $this->emit('respuestaValidacion', true);
        }
        else
        {
            Authorization::where('user_id', Auth::user()->id)->delete();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'El codigo no coincide, vuelva a intentarlo.',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        return;
    }


    public function agregarOferta($i)
    {
        $this->product_ofertas[] = [
            'product_detail_id' => $i,
            'precio_total' => 0,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_final' => now()->addMonth()->format('Y-m-d'),
        ];

        $this->emit('refreshComponent');
    }

    public function eliminarOferta($z)
    {
        array_splice($this->product_ofertas, $z, 1);
        $this->emit('refreshComponent');
    }

    public function setPrecioOferta($z, $val)
    {
        $this->product_ofertas[$z]['precio_total'] = intval($val);
    }

    public function agregarPrecio()
    {
        ++$this->product_details;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;
    }

    public function refreshParent()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        //  Actualiza las categorias del datalist
        $this->dispatchBrowserEvent('updateBrand', [
            'value' => (ProductBrand::orderBy('created_at', 'desc')->first())->name 
        ]);
        
        $this->dispatchBrowserEvent('updateCategory', [
            'value' => (ProductCategory::orderBy('created_at', 'desc')->first())->name
        ]);
    }

    /* Montar los Select options y datalist */
    public function mount(Request $req)
    {
        $product = \App\Models\Product::with(['product_presentations', 'product_categories', 'product_details', 'product_brands'])->hashid($req->hashid)->firstOrFail();

        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        /* Datos del producto */
        $this->product_presentation_id = $product->product_presentation_id;
        $this->name = $product->name;
        $this->palabras_clave = $product->palabras_clave;
        $this->barcode = $product->barcode;
        $this->amount = $product->stock;
        $this->amount_presentation = $product->amount_presentation;
        $this->precio_compra = $product->precio_compra;
        $this->alerta_stock = $product->alerta_stock;

        /* Cantidad de subproductos */
        $this->product_details = count($product->product_details);

        foreach ($product->product_details as $product_detail)
        {
            $this->discount_details[] = $product_detail->discount;

            $this->precio_venta_details[] = $product_detail->precio_venta_sin_igv;

            $this->precio_venta_con_igv_details[] = $product_detail->precio_venta_con_igv;

            $this->precio_venta_total[] = $product_detail->precio_venta_total;

            $this->product_presentation_details_id[] = $product_detail->product_presentation_id;


            foreach ($product_detail->offers as $index => $offer)
            {
                $this->product_ofertas[] = [
                    'product_detail_id' => $index,
                    'precio_total' => $offer->precio,
                    'fecha_inicio' => $offer->fecha_inicio,
                    'fecha_final' => $offer->fecha_final,
                ];
            }

        }

        $this->product = $product;
    }

    public function getBarcode()
    {
        $barcode = random_int(100000000000, 999999999999);

        /* verificar que el barcode no existe */
        while (\App\Models\Product::where('barcode', $barcode)->count())
        {
            $barcode = random_int(100000000000, 999999999999);
        }

        $this->barcode = $barcode;
    }
    
    public function render()
    {
        return view('livewire.dashboard.show.product', [
            'product_brands' => $this->product_brands,
            'product_categories' => $this->product_categories,
            'product_presentations' => ProductPresentation::get(),
        ]);
    }

}

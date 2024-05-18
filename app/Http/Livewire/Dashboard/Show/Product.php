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

    public $product_presentation_oferta_id = [];

    public $product_ofertas = [
        // 'product_detail_id',
        // 'precio_total',
        // 'fecha_inicio',
        // 'fecha_final',
        // 'active',
    ];

    public function calcularGanancia()
    {

        foreach ($this->precio_venta_total as $key => $value)
        {
            if($value != null && $value > 0)
            {
                //$ganancia = (($this->precio_venta_details[$key] - $value) / $value) * 100;

                //$con_igv = (($this->precio_venta_details[$key] * 0.18) + $this->precio_venta_details[$key]);
                
                //ddd(($con_igv + ($con_igv * 0.4)));

                //if($value > ($con_igv + ($con_igv * 0.4)))
                //{
                    return ['total', $key];
                //}
            }
            else
            {
                // incompleto
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Debes completar todos los campos antes de continuar.',
                    'icon' => 'error',
                    'iconColor' => 'red',
                ]);
                return false;
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

            if($oferta[0] == 'total')
            {
                $product_detail_id = $oferta[1];
                $precio_total = $this->precio_venta_total[$oferta[1]];
            }
            else
            {
                $product_detail_id = $oferta[1]['product_detail_id'];
                $precio_total = $oferta[1]['precio_total'];
            }

            /***
             * FORMATEAR UNIDADES
             * */
            $unidades = [];

            for ($i=0; $i < $this->product_details; $i++)
            { 
                $unidades[] = [
                    'presentacion' => (ProductPresentation::select('name')->where('id', $this->product_presentation_details_id[$i])->first())->name,
                    'precio_venta' => 'S/ '.$this->precio_venta_details[$i],
                    'precio_total' => 'S/ '.$this->precio_venta_total[$i],
                ];
            }

            /**
             * VIEW DE LA TABLA PARA EL EMAIL
             * */
            $product = [
                'producto' => [
                    'name' => $this->name,
                    'unidades_total' => $this->product_details,
                    'ofertas_total' => count($this->product_ofertas),
                ],
                'unidades' => $unidades,
            ];

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


    public function agregarOferta()
    {
        $this->product_ofertas[] = [
            'precio_total' => 0,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_final' => now()->addMonth()->format('Y-m-d'),
            'active' => true,
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
        $product = \App\Models\Product::with(['product_presentations', 'product_categories', 'product_details', 'product_brands', 'offers'])->hashid($req->hashid)->firstOrFail();

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
        }

        /* Offers */
        if($product->offers != null)
        {
            foreach ($product->offers as $offer)
            {
                $this->product_presentation_oferta_id[] = $offer->product_presentation_id-1;

                $this->product_ofertas[] = [
                    'precio_total' => $offer->precio,
                    'fecha_inicio' => $offer->fecha_inicio,
                    'fecha_final' => $offer->fecha_final,
                    'active' => $offer->active,
                ];
            }

            //ddd([$this->product_ofertas, $this->product_presentation_details_id]);
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

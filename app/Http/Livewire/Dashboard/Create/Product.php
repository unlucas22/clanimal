<?php

namespace App\Http\Livewire\Dashboard\Create;

use Livewire\Component;
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
    public $barcode = null;
    public $alerta_stock = 1;

    /* Stock */
    public $amount = 1;
    /* Stock por Presentacion */
    public $amount_presentation = 1;

    /* ¿Precio compra en 0 siempre? */
    public $precio_compra = 1;

    /*** Datos de SubProductos ***/

    /* Se hace un foreach por cada id en el Controlador */
    public $product_details = 1;

    /* Descuento */
    public $discount_details = [
        0
    ];
    /* Precio de Venta */
    public $precio_venta_details = [
        0
    ];
    /* Precio de Venta con impuestos */
    public $precio_venta_con_igv_details = [
        0
    ];

    public $precio_venta_total = [
        0
    ];
    
    /* Tipo de Presentacion */
    public $product_presentation_details_id = [
        1
    ];

    public $unidades_guardados = [];

    public $product_presentation_oferta_id = [];

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
        foreach ($this->precio_venta_total as $key => $value)
        {
            if($value != null && $value > 0)
            {
                $ganancia = (($this->precio_venta_details[$key] - $value) / $value) * 100;

                if($ganancia > 40)
                {
                    return ['total', $key];
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

            $pp = ProductPresentation::select('name')->where('id', $this->product_presentation_details_id[$product_detail_id])->first();

            // descripcion de la unidad
            $product = $pp->name.'. Precio Venta con IGV: S/ '.$this->precio_venta_details[$product_detail_id].'. Precio Total: S/ '.$precio_total;


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

    /* Hace referencia a los datalist */
    public function refreshParent()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        //  Actualiza las marcas del datalist
        $this->dispatchBrowserEvent('updateBrand', [
            'value' => (ProductBrand::orderBy('created_at', 'desc')->first())->name
        ]);

        //  Actualiza las categorias del datalist
        $this->dispatchBrowserEvent('updateCategory', [
            'value' => (ProductCategory::orderBy('created_at', 'desc')->first())->name
        ]);
    }

    /***
     *  Añadir o Remover unidades y precios
     * */
    public function agregarPrecio()
    {
        ++$this->product_details;
    }

    public function eliminarPrecio()
    {
        --$this->product_details;
    }

    /* Montar los Select options y datalist */
    public function mount()
    {
        $this->product_brands = ProductBrand::where('active', true)->get();
        $this->product_categories = ProductCategory::where('active', true)->get();

        /* Valores Default */
        $this->product_brand_id = (ProductBrand::first())->id ?? null;
        $this->product_category_id = (ProductCategory::first())->id ?? null;
        $this->product_presentation_id = (ProductPresentation::first())->id ?? null;
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
        return view('livewire.dashboard.create.product', [
            'product_brands' => $this->product_brands,
            'product_categories' => $this->product_categories,
            'product_presentations' => ProductPresentation::get(),
        ]);
    }
}

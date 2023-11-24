<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_brand_id',
        'product_category_id',
        'user_id',
        'active',
        'precio_compra',
        'precio_venta',
        'stock',
        'barcode',
        'palabras_clave',
        'fecha_de_vencimiento',
        'alerta_stock',
        'photo_path',
        'amount',
        'product_presentation_id',
        'amount_presentation',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'photo_url',
        'fecha_de_vencimiento_formatted',
        'ganancia',
        'precio_venta_total'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_de_vencimiento' => 'datetime',
    ];

    public function getPrecioVentaTotalAttribute()
    {
        $products = $this->product_details;

        $precio_venta_con_igv = 0;

        foreach ($products as $product)
        {
            $precio_venta_con_igv += $product->precio_venta_con_igv;
        }

        return $precio_venta_con_igv;
    }

    public function getGananciaAttribute()
    {
        $products = $this->product_details;

        $precio_venta_con_igv = 0;
        $precio_venta_sin_igv = 0;

        $tasa_impuesto = 18;

        foreach ($products as $product)
        {
            $precio_venta_con_igv += $product->precio_venta_con_igv;
            $precio_venta_sin_igv += $product->precio_venta_sin_igv;
        }

        $impuestos = $precio_venta_sin_igv * ($tasa_impuesto / 100);

        $total = ($precio_venta_con_igv - $impuestos) - $this->precio_compra;

        return doubleval( ($total / $this->precio_compra) * 100);
    }


    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function getFechaDeVencimientoFormattedAttribute()
    {
        return $this->fecha_de_vencimiento->format('Y-m-d');
    }

    public function product_brands()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id', 'id');
    }

    public function product_categories()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function product_presentations()
    {
        return $this->belongsTo(ProductPresentation::class, 'product_presentation_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    /**
     * Delete the product's photo.
     *
     * @return void
     */
    public function deletePhoto()
    {
        if (is_null($this->photo_path)) {
            return;
        }

        Storage::disk('public')->delete($this->photo_path);

        $this->forceFill([
            'photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the product's photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path
                    ? Storage::disk('public')->url($this->photo_path)
                    : null;
    }
}

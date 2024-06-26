<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Hashids;

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
        'barcode',
        'palabras_clave',
        'fecha_de_vencimiento',
        'alerta_stock',
        'photo_path',
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
        'precio_venta_total',
        'stock_total',
        'formatted_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_de_vencimiento' => 'datetime',
    ];

    public function getFormattedActiveAttribute()
    {
        return $this->active ? '
        <div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Activo
        </div>' : '<div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
        </div>';
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function scopeWithStock($query)
    {
        return $query->where('stock', '!=', 0)->where('active', 1)->limit(5);
    }

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

    public function getStockTotalAttribute()
    {

        $products = $this->product_details;

        $stock = 0;

        foreach ($products as $product)
        {
            $stock += $product->amount ?? 0;
        }

        return $stock;
    }

    public function getGananciaAttribute()
    {
        $products = $this->product_details;

        $precio_venta_sin_igv = 0;

        $tasa_impuesto = 18;

        foreach ($products as $product)
        {
            if($product->product_presentation_id == $this->product_presentation_id)
            {
                $precio_venta_sin_igv += $product->precio_venta_sin_igv;
            }
        }

        if($this->precio_compra == 0 || $this->precio_compra == null)
        {
            return 0;
        }

        $ganancia = $precio_venta_sin_igv - $this->precio_compra;

        return doubleval( ($ganancia / $this->precio_compra) * 100);
    }

    public function product_in_warehouses()
    {
        return $this->hasMany(ProductInWarehouse::class);
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function getFechaDeVencimientoFormattedAttribute()
    {
        if($this->fecha_de_vencimiento !== null)
        {
            return $this->fecha_de_vencimiento->format('Y-m-d');
        }
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

    public function offers()
    {
        return $this->hasMany(Offer::class);
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

    public function product_for_packs()
    {
        return $this->hasOne(ProductForPack::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Unidades y Precios de Producto */
class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_presentation_id',
        'amount',
        'discount',
        'precio_venta_sin_igv',
        'precio_venta_con_igv',
        'product_id',
    ];

    public function descuento()
    {
        $descuento = ($this->discount / 100) * $this->precio_venta_con_igv;

        return $this->precio_venta_con_igv - $descuento;
    }

    public function product_presentations()
    {
        return $this->belongsTo(ProductPresentation::class, 'product_presentation_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product_for_sales()
    {
        return $this->hasMany(ProductForSale::class);
    }
}

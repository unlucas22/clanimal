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
        'discount',
        'precio_venta_sin_igv',
        'precio_venta_con_igv',
        'product_id',
        'active',
    ];

    /* descuento en precio venta con impuestos */
    public function descuento()
    {
        return $this->precio_venta_con_igv - $this->discount;
    }

    /* La diferencia en unidad, no porcentaje */
    public function diferenciaConImpuestos()
    {
        return $this->precio_venta_con_igv - $this->precio_venta_sin_igv;
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

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}

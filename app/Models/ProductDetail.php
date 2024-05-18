<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/* Unidades y Precios de Producto */
class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_presentation_id',
        'discount',
        'precio_venta_sin_igv',
        'precio_venta_con_igv',
        'precio_venta_total',
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

    public function getPrecioDeOferta()
    {
        $ofertaActiva = \App\Models\Offer::where('product_id', $this->product_id)->where('product_presentation_id', $this->product_presentation_id)->where('fecha_inicio', '<=', Carbon::now())
                         ->where('fecha_final', '>=', Carbon::now())
                         ->where('active', true)->first();

        // Si hay una oferta activa, utilizar su precio total
        if ($ofertaActiva)
        {
            return $ofertaActiva->precio;
        }

        // Si no hay oferta activa, retornar el precio de unidad por defecto
        return null;
    }
}

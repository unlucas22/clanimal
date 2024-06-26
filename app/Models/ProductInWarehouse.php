<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'product_presentation_id',
        'amount',
        'discount',
        'precio_venta_sin_igv',
        'precio_venta_con_igv',
        'fecha_de_vencimiento',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
    ];

    public function product_presentations()
    {
        return $this->belongsTo(ProductPresentation::class, 'product_presentation_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function product_stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function aplicarDescuento()
    {
        return doubleval($this->precio_venta_con_igv) - doubleval($this->discount);
    }

    public function getTotalAttribute()
    {
        return $this->aplicarDescuento();
    }
}

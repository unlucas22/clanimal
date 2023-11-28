<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductForSale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_detail_id',
        'bill_id',
        'cantidad',
    ];

    public function product_details()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id');
    }

    /* Calcular total con impuestos y descuentos */
    public function getTotalByAmount()
    {
        $total = 0;

        for ($i=0; $i < $this->cantidad; $i++)
        { 
            $total += $this->product_details->descuento();
        }

        return $total;
    }

    /* obtener subtotal, sin impuestos */
    public function getSubTotalByAmount()
    {
        $total = 0;

        for ($i=0; $i < $this->cantidad; $i++)
        { 
            $total += $this->product_details->precio_venta_sin_igv;
        }

        return $total;
    }
}

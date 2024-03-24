<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLot extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_detail_id',
        'product_stock_id',
        'stock',
        'fecha_de_vencimiento',
        'fecha_de_compra',
        'precio_compra',
        'descuento',
    ];

    public function product_details()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function product_stocks()
    {
        return $this->hasOne(ProductStock::class);
    }
}

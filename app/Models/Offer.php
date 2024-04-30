<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_detail_id',
        'precio',
        'active',
        'fecha_inicio',
        'fecha_final',
    ];

    public function product_details()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id');
    }

}

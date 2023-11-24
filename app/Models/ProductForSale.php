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
        'cantidad',
    ];

    public function product_details()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id');
    }
}

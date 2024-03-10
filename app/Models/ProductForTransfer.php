<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductForTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'product_detail_id',
        'stock'
    ];

    public function product_details()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id');
    }

    public function transfers()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Toma el stock del warehouse
 * */
class ProductForTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        //'product_detail_id',
        'stock',
        'product_stock_id'
    ];

    public function product_stocks()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id', 'id');
    }

    public function transfers()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }
}

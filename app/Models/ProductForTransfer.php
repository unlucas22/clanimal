<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductForTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'stock'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transfers()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }
}

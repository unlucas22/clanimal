<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_in_warehouse_id',
        'stock',
    ];

    public function product_in_warehouses()
    {
        return $this->belongsTo(ProductInWarehouse::class, 'product_in_warehouse_id', 'id');
    }

    public function product_for_transfers()
    {
        return $this->hasMany(ProductForTransfer::class);
    }
}

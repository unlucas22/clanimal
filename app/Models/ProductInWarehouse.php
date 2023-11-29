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
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
}

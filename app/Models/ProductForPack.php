<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductForPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'pack_id',
    ];

    public function packs()
    {
        return $this->belongsTo(Pack::class, 'pack_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

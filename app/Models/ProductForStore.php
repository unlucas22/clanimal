<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Este modelo es para aquellos productos que se reciben en la tienda
 * o bien se asignan sin la necesidad de recepción
 * */
class ProductForStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'product_id',
        'stock',
        'fecha',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}

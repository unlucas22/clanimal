<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Marcas de Producto */
class ProductBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];
}

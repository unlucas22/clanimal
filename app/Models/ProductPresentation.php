<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Presentación de producto */
class ProductPresentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}

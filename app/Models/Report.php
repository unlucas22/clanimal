<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * En un futuro el modelo report tendrá columnas de Analytics para el control del cliente
 * */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
    ];
}

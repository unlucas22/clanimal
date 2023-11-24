<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'metodo_de_pago',
        'user_id',
        'igv',
        'razon_social',
        'ruc',
    ];
}

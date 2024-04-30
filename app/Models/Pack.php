<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fecha_inicio',
        'fecha_final',
        'precio',
        'active',
    ];

    public function product_for_packs()
    {
        return $this->hasMany(ProductForPack::class);
    }
}

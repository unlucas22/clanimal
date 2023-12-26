<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ruc',
        'phone',
        'address',
        'cuenta_bancaria',
        'banco',
        'beneficiario',
        'moneda',
    ];

    public function product_for_stores()
    {
        return $this->hasMany(ProductForStore::class);
    }
}

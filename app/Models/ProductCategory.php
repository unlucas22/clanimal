<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Categorías de Producto */
class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_active',
    ];

    public function getFormattedActiveAttribute()
    {
        return $this->active ? 'Activo' : 'Inactivo';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

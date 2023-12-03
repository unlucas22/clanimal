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
        return $this->active ? '
        <div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Activo
        </div>' : '<div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
        </div>';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

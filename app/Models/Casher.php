<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'company_id',
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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getFormattedActiveAttribute()
    {
        return $this->active ? '
        <div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Activo
        </div>' : '<div class="flex items-center">
             <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
        </div>';
    }
}

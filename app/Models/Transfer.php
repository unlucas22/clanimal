<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

/**
 * Modelo para el registro de salidas de productos a sedes 
**/
class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'status',
        'motivo',
        'fecha_envio',
        'fecha_recepcion',
    ];

    // ['completado', 'en proceso', 'cancelado']

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_recepcion' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status_formatted',
        'hashid',
    ];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status)
        {
            case 'completado':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'en proceso':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En proceso</span>';
                break;
            
            default:
                return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Cancelado</span>';
                break;
        }
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function product_for_transfers()
    {
        return $this->hasMany(ProductForTransfer::class);
    }
}

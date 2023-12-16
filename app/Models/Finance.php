<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_tarjetas',
        'total_efectivo',
        'status',
        'reported_at',
        'numero_operacion'
    ]; // ['validacion', 'completado', 'observado']

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'total',
        'formatted_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function getTotalAttribute()
    {
        return $this->total_tarjetas + $this->total_efectivo;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getFormattedStatusAttribute()
    {
        switch($this->status)
        {
            case 'validacion':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-green-900 dark:text-green-300">Espera de validación</span>';
                break;

            case 'completado':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'observado':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-yellow-900 dark:text-yellow-300">Observado</span>';
                break; 
        }
    }
}

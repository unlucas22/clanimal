<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'casher_id',
        'closed_at',
        'validated_at',
        'en_caja',
        'total_efectivo',
        'total_tarjeta',
        'total_virtual',
        'total_credito',
        'status',
    ]; // ['en proceso', 'validacion', 'completado', 'rechazado']

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'total',
        'formatted_status',
        'formatted_en_caja',
        'formatted_total_efectivo',
        'formatted_total_tarjeta',
        'formatted_total_virtual',
        'formatted_total_credito',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function getTotalAttribute()
    {
        return $this->en_caja - $this->total_tarjeta + $this->total_virtual + $this->total_efectivo + $this->total_credito;
    }

    public function getFormattedEnCajaAttribute()
    {
        return 'S/ '.$this->en_caja.' Soles';
    }

    public function getFormattedTotalEfectivoAttribute()
    {
        return 'S/ '.$this->total_efectivo.' Soles';
    }

    public function getFormattedTotalTarjetaAttribute()
    {
        return 'S/ '.$this->total_tarjeta.' Soles';
    }

    public function getFormattedTotalVirtualAttribute()
    {
        return 'S/ '.$this->total_virtual.' Soles';
    }

    public function getFormattedTotalCreditoAttribute()
    {
        return 'S/ '.$this->total_credito.' Soles';
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function cashers()
    {
        return $this->belongsTo(Casher::class, 'casher_id', 'id');
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getFormattedStatusAttribute()
    {
        switch($this->status)
        {
            case 'en proceso':
                return '<span class="block bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-blue-900 dark:text-blue-300">En proceso</span>';
                break;

            case 'validacion':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-green-900 dark:text-green-300">Espera de validación</span>';
                break;

            case 'completado':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'rechazado':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-yellow-900 dark:text-yellow-300">Rechazado</span>';
                break; 
        }
    }
}

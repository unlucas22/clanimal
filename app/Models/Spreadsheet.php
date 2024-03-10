<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class Spreadsheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'validated_at',
        'fecha',
    ];

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
        'validated_at' => 'datetime',
        'fecha' => 'datetime',
    ];

    public function getTotalAttribute()
    {
        // foreach por estados completados
        return 0;
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function user_for_spreadsheets()
    {
        return $this->hasMany(UserForSpreadsheet::class);
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getFormattedStatusAttribute()
    {
        switch($this->status)
        {
            case 'pendiente':
                return '<span class="block bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-gray-900 dark:text-gray-300">Pendiente</span>';
                break;

            case 'validacion':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-yellow-900 dark:text-yellow-300">En Proceso de Validación</span>';
                break;

            case 'completado':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'cancelado':
                return '<span class="block bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full text-center dark:bg-red-900 dark:text-red-300">Cancelado</span>';
                break; 
        }
    }

}

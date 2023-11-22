<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * En un futuro el modelo Report tendrá columnas de Analytics para el control del cliente,
 * por el momento es solo para su clasificacion
 * */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_status'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Para los cruds
     * */
    public function getFormattedStatusAttribute()
    {
        switch($this->key)
        {
            case 'ocasional':
                return '<span class="block bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Ocasional</span>';
                break;

            case 'regular':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Básico</span>';
                break;

            case 'default':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Sin definir</span>';
                break;

            case 'VIP':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">VIP</span>';
                break; 
        }
    }
}

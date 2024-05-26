<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'email',
    ]; // type: success, warning, error

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type_formatted',
        'email_formatted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getEmailFormattedAttribute()
    {
        return $this->email ? '
        <div class="flex items-center justify-center">
             <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Habilitado
        </div>' : '<div class="flex items-center justify-center">
             <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
        </div>';
    }

    public function notices()
    {
        return $this->hasOne(Notice::class);
    }

    public function getTypeFormattedAttribute()
    {
        switch($this->type)
        {
            case 'success':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Personalizado</span>';
                break;

            case 'error':
                return '<span class="block bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Error</span>';
                break;

            case 'warning':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Sistema</span>';
                break;

        }
    }
}

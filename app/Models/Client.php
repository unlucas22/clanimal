<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'user_id',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'formatted_status'
    ];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }
    
    /**
     * Para los cruds
     * */
    public function getFormattedStatusAttribute()
    {
        switch($this->status)
        {
            case 'ocasional':
                return '<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Ocasional</span>';
                break;

            case 'regular':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Básico</span>';
                break;

            case 'VIP':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">VIP</span>';
                break; 
        }
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'pet_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_path',
    ];
    
    public function pets()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }


    public function getFormattedPathAttribute()
    {
        return asset('storage/'.$this->path);
    }
}

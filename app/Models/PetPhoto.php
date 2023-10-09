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

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }
}

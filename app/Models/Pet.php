<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'weight',
        'height',
        'age',
        'gender',
        'note',
        'type_of_pet_id',
        'client_id',
    ];

    public function type_of_pets()
    {
        return $this->belongsTo(TypeOfPet::class, 'type_of_pet_id', 'id');
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function pet_photos()
    {
        return $this->hasMany(PetPhoto::class);
    }
}

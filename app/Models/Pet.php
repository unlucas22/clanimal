<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
    ];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

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

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }
}

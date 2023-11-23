<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presale extends Model
{
    use HasFactory;

    /* pet_id puede ser nullable porque se puede generar una venta sin necesidad de asignar a la mascota, pero si en atención y peluqueria */
    protected $fillable = [
        'price',
        'description',
        'client_id',
        'user_id',
        'pet_id',
        'sale_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sales()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }

    public function presale_photos()
    {
        return $this->hasMany(PresalePhoto::class);
    }
}

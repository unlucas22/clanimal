<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_name_emergency',
        'contact_phone_emergency',
        'contact_type_emergency',
        'cuenta_bancaria',
        'payment_method_id',
        'fecha_de_contratacion',
        'fecha_de_cese',
    ]; // type => Madre, padre, hermano

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_de_contratacion' => 'datetime',
        'fecha_de_cese' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment_methods()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }      
}

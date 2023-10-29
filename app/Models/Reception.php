<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    /* shift_id puede ser nulo, es decir, no tuvo cita previa */
    protected $fillable = [
        'user_id',
        'pet_id',
        'service_id',
        'shift_id',
        'entry',
        'delivery',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'entry' => 'datetime',
        'delivery' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }

    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function shifts()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }
}

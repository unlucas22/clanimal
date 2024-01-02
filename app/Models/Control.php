<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class Control extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hostname',
        'ip',
        'city',
        'device',
        'reason_id',
        'company_id',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'date_formatted',
    ];

    public function getDateFormattedAttribute()
    {
        return $this->date->format('d/m/Y h:i A');
    } 

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reasons()
    {
        return $this->belongsTo(Reason::class, 'reason_id', 'id');
    }
}

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
        'confirmed',
        'reason_id',
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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reasons()
    {
        return $this->belongsTo(Reason::class, 'reason_id', 'id');
    }

    public function isActive()
    {
        return $this->confirmed;
    }
}

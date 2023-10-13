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
        'report_id',
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

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reports()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }

}

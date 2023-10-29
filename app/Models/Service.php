<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}

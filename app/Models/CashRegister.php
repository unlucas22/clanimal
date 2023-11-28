<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'closed_at',
        'amount',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

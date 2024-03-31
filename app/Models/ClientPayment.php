<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuota',
        'client_id',
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}

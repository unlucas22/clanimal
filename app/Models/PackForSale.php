<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackForSale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pack_id',
        'bill_id',
        'cantidad',
    ];

    public function packs()
    {
        return $this->belongsTo(Pack::class, 'pack_id', 'id');
    }

    public function bills()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }
}

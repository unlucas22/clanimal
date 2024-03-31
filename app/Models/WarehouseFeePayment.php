<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseFeePayment extends Model
{
    use HasFactory;

    public $fillable = [
        'cuota',
        'warehouse_payment_id',
        'status',
        'fecha',
    ];

    public function warehouse_payments()
    {
        return $this->belongsTo(WarehousePayment::class, 'warehouse_payment_id', 'id');
    }
}

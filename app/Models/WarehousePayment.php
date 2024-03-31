<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehousePayment extends Model
{
    use HasFactory;

    public $fillable = [
        'cuotas',
        'warehouse_id'
    ];

    public function warehouse_fee_payments()
    {
        return $this->hasMany(WarehouseFeePayment::class);
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
}

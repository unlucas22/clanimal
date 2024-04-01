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

    public function getStatusFormattedAttribute()
    {
        switch ($this->status)
        {
            case 'completado':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'en espera':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En espera</span>';
                break;
        }
    }
}

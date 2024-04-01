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

    public function getMontoPagado()
    {
        $monto = 0;

        foreach ($this->warehouse_fee_payments as $fee)
        {
            if($fee->status == 'completado')
            {
                $monto += $fee->cuota; 
            }
        }

        return $monto;
    }

    public function getMontoRestante()
    {
        $monto = 0;

        $res = $this->warehouses->total - $this->getMontoPagado();

        return $res > 0 ? $res : 0;
    }

    public function getCuotasPagadas()
    {
        $cuotas_pagadas = 0;

        foreach ($this->warehouse_fee_payments as $fee)
        {
            if($fee->status == 'completado')
            {
                $cuotas_pagadas++; 
            }
        }

        return $cuotas_pagadas;
    }
}

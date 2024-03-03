<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

/**
 * Almacen donde se reciben los productos de los proveedores
 * */
class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'fecha',
        //'factura',
        'key_type',
        'value_type',
        'total',
        'status',
        'supplier_id',
        'motivo', // motivo del estado cancelado
        'observation',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'monto',
        'monto_formatted',
        'status_formatted',
        'hashid',
        'fecha_formatted',
        'total_formatted',
    ];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getFechaFormattedAttribute()
    {
        return $this->fecha->format('d/m/Y h:i A');
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status)
        {
            case 'crédito':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Crédito</span>';
                break;

            case 'contado':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Contado</span>';
                break;

            case 'pendiente':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>';
                break;
            
            default:
                return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Cancelado</span>';
                break;
        }
    }

    public function getTotalFormattedAttribute()
    {
        return 'S/ '.$this->total.' Soles';
    }

    /* Obtener el total de todos los productos segun precio compra */
    public function getMontoAttribute()
    {
        $monto = 0;

        foreach ($this->product_in_warehouses as $warehouse)
        {
            $monto += $warehouse->products->precio_compra;
        }

        return $monto;
    }

    /* Obtener el monto con signo unidad */
    public function getMontoFormattedAttribute()
    {
        return '$'.$this->monto;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    /**
     * Con esto se asigna el nuevo producto al warehouse, 
     * en vez de tener un nullable en products del warehouse
     * */
    public function product_in_warehouses()
    {
        return $this->hasMany(ProductInWarehouse::class);
    }
}

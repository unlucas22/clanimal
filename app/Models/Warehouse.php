<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'factura',
        'total',
        'status',
        'supplier_id',
    ];

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

    //$table->enum('status', ['crédito', 'pendiente' ,'cancelado'])->default('pendiente');
}

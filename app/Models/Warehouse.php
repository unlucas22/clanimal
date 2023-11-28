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
        'company_id',
        'product_id',
        'stock',
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

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    //$table->enum('status', ['crédito', 'pendiente' ,'cancelado'])->default('pendiente');
}

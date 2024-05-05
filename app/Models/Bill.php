<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'metodo_de_pago',
        'user_id',
        'pet_id',
        'total',
        'igv',
        'razon_social',
        'ruc',
        'referente_id',
        'enlace',
        'status',
        'factura',
    ]; // status: 'en proceso', 'completado', 'cancelado'

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'metodo_de_pago_formatted',
        'status_formatted',
    ];

    public function getMetodoDePagoFormattedAttribute()
    {
        switch ($this->metodo_de_pago) {
            case 'efectivo':
                return 'Efectivo';
                break;
            case 'tarjeta':
                return 'Debito';
                break;
            case 'virtual':
                return 'Yape/Plin/QR';
                break;
            case 'credito':
                return 'Crédito';
                break;
        }
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status)
        {
            case 'completado':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'en proceso':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En proceso</span>';
                break;
            
            default:
                return '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Cancelado</span>';
                break;
        }
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pets()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }

    public function referentes()
    {
        return $this->belongsTo(User::class, 'referente_id', 'id');
    }

    public function product_for_sales()
    {
        return $this->hasMany(ProductForSale::class);
    }

    public function pack_for_sales()
    {
        return $this->hasMany(PackForSale::class);
    }
}

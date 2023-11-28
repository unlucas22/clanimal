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
        'total',
        'igv',
        'razon_social',
        'ruc',
        'referente_id',
        'enlace',
        'tarjeta',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'metodo_de_pago_formatted',
    ];

    public function getMetodoDePagoFormattedAttribute()
    {
        switch ($this->metodo_de_pago) {
            case 'efectivo':
                return 'Efectivo';
                break;
            case 'tarjeta':
                return 'Debito/Credito';
                break;
            case 'virtual':
                return 'Yape/Plin/QR';
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

    public function referentes()
    {
        return $this->belongsTo(User::class, 'referente_id', 'id');
    }

    public function product_for_sales()
    {
        return $this->hasMany(ProductForSale::class);
    }
}

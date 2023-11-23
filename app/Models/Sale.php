<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
El cálculo de IGV se hace aplicando el 18% en caso de tener el importe base, por ejemplo:
IGV =  Importe Base x 0.18

En caso de saber el importe total es decir incluido IGV entonces el cálculo sería así:

Primero obtenemos el monto base de la siguiente manera:

Base = Total / (1 + 0.18)  o Base = Total / 1.18

Finalmente restando el monto total menos el monto base nos da como resultado el IGV:

IGV =  Total – Base
*/
class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'metodo_de_pago',
        'user_id',
        'igv',
        'active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
    ];

    public function getTotalAttribute()
    {
        $total = 0;

        foreach($this->presales as $presale)
        {
            $total += $presale->price;
        }

        return $total;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function presales()
    {
        return $this->hasMany(Presale::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}

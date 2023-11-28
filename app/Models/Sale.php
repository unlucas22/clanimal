<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Sale ------> Factura */
class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
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

    public function scopeActive($qry)
    {
        return $qry->where('active', true);
    }
}

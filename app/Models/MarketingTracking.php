<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class MarketingTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_campaign_id',
        'user_id',
        'status',
        'open_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'open_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'formatted_status',
    ];

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function marketing_campaigns()
    {
        return $this->belongsTo(MarketingCampaign::class, 'marketing_campaign_id', 'id');
    }

    public function getFormattedStatusAttribute()
    {
        if( $this->marketing_campaigns->status == 'en proceso' || $this->marketing_campaigns->status == 'completado' )
        {
            if($this->open_at != null)
            {
                return '<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Enviado</span>';
            }
            else
            {
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>';
            }
        }
        else
        {
            return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Programado</span>';
        }
    }  

}

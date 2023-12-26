<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids;

class MarketingCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'marketing_template_id',
        'fecha',
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
        'hashid',
        'formatted_status',
        'formatted_fecha',
    ];

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    public function getFormattedFechaAttribute()
    {
        return $this->fecha->format('Y-m-d');
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function marketing_templates()
    {
        return $this->belongsTo(MarketingTemplate::class, 'marketing_template_id', 'id');
    }

    public function marketing_trackings()
    {
        return $this->hasMany(MarketingTracking::class);
    }

    public function getFormattedStatusAttribute()
    {
        switch($this->status)
        {
            case 'en proceso':
                return '<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">En proceso</span>';
                break;

            case 'completado':
                return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>';
                break;

            case 'programado':
                return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Programado</span>';
                break;
        }
    }   
}

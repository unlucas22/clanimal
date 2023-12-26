<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Hashids;

class MarketingTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'image',
        'button_text',
        'button_url',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
        'hashid',
    ];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function scopeHashid($query, $hashid)
    {
        return $query->where('id', Hashids::decode($hashid));
    }

    /**
     * Delete the product's photo.
     *
     * @return void
     */
    public function deleteImage()
    {
        if (is_null($this->image)) {
            return;
        }

        Storage::disk('public')->delete($this->image);

        $this->forceFill([
            'image' => null,
        ])->save();
    }

    /**
     * Get the URL to the product's photo.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->image
                    ? Storage::disk('public')->url($this->image)
                    : null;
    }

    public function marketing_campaigns()
    {
        return $this->hasMany(MarketingCampaign::class);
    }
}

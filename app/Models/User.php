<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasHistories;
use Hashids;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    use HasHistories;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'deleted_at',
        'cedula',
        'company_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashid',
        'profile_photo_url',
    ];

    public function isCajaOpen()
    {
        return \App\Models\CashRegister::where('casher_id', $this->id)->where('status', 'en proceso')->count();
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function isActive()
    {
        return $this->email_verified_at !== null || $this->deleted_at !== null;
    }

    public function isAdmin()
    {
        return $this->role_id == (\App\Models\Role::select('id')->where('key', 'administrador')->first())->id;
    }

    public function manpowers()
    {
        return $this->hasOne(Manpower::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function controls()
    {
        return $this->hasMany(Control::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function cashers()
    {
        return $this->hasMany(Casher::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

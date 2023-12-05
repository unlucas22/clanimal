<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function permission_for_roles()
    {
        return $this->hasMany(PermissionForRole::class);
    }

    public $timestamps = false;
}

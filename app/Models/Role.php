<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'sueldo',
    ];

    public function permission_for_roles()
    {
        return $this->hasMany(PermissionForRole::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

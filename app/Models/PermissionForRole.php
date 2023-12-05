<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionForRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}

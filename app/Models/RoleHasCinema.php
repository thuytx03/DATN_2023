<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasCinema extends Model
{
    use HasFactory;
    protected $table = 'role_has_cinemas';

    // Khai báo mối quan hệ với bảng Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Khai báo mối quan hệ với bảng Cinema
    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
}

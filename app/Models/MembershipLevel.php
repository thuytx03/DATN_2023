<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipLevel extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'membership_levels';

    protected $fillable = [
        'name', 'min_limit', 'max_limit', 'benefits', 'status', 'Description','benefits_food'
    ];
}

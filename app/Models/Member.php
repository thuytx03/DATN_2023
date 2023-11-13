<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'members';

    protected $fillable = [
        'card_number', 'total_bonus_points', 'current_bonus_points', 'level_id','level_id_old', 'user_id','status'
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\MembershipLevel', 'level_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

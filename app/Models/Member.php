<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'card_number', 'total_bonus_points', 'bonus_points_will_be_received', 'current_bonus_points', 'level_id','level_id_old', 'user_id','status','total_spending'
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\MembershipLevel', 'level_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }
}

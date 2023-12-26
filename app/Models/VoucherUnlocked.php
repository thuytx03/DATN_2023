<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUnlocked extends Model
{
    use HasFactory;
    protected $table="voucher_unlocked";
    protected $fillable=['user_id','voucher_id','unlocked','status'];
}

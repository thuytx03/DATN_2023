<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMent_PayPal extends Model
{
    use HasFactory;
    protected $table = 'payment_paypal';
    public $fillable = ['total','booking_id'];
}

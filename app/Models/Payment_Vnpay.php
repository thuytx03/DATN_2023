<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_Vnpay extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payment_vnpay';
    public $fillable = ['vnp_TransactionNo','vnp_BankCode','vnp_BankTranNo','vnp_CardType','vnp_OrderInfo','vnp_PayDate','vnp_ResponseCode','vnp_TmnCode','vnp_TransactionStatus','vnp_TxnRef','vnp_SecureHash','vnp_Amount'];
}

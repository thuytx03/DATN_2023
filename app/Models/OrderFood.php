<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFood extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'order_foods';
    protected $fillable = [
        'user_id',
        'cinema_id',
        'email',
        'order_date',
        'order_end',
        'total_amount',
        'payment_method',
        'note',
        'reason',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetailFood::class);
    }
}

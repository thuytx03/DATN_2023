<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailFood extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'order_detail_foods';
    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(OrderFood::class);
    }

    public function food()
    {
        return $this->belongsTo(MovieFood::class);
    }
}

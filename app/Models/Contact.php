<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'contact';
    public $timestamps = true;
    public $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];
}

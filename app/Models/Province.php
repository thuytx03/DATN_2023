<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamp = true;
    public $table = 'provinces';
    public $fillable = ['name', 'slug', 'image',  'description', 'status'];

    
}

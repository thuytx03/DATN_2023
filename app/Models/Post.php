<?php

namespace App\Models;
use App\Models\User;
use App\Models\PostTypes;
use App\Models\Post_Type_Post;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['title','content','slug','image','user_id','status'];
    protected $casts = [
        'status' => 'integer',
    ];
    
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
      public function postTypes()
    {
        return $this->belongsToMany(PostTypes::class, 'post_post_type', 'post_id', 'post_type_id','parent_id');
    }
    public function postTypePosts()
    {
        return $this->hasMany(Post_Type_Post::class, 'post_id');
    }
}


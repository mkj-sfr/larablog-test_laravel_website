<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function blog() {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function comments_relation() {
        return $this->hasOne(CommentsRelation::class, 'reply_id');
    }
}

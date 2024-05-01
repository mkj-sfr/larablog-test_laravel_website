<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters) {
        if($filters['tags'] ?? false) {
            $query->where('tags', 'like', '%' . $filters['tags'] . '%');
        }
        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
            ->orWhere('body', 'like', '%' . $filters['search'] . '%')
            ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
        }
        if($filters['category'] ?? false) {
            $searched_category = Category::where('name', '=', $filters['category'])->get();
            $query->where('category_id', '=', $searched_category[0]->id);
        }
        if($filters['name'] ?? false) {
            $searched_user = User::where('last_name', '=', $filters['name'])->get();
            $query->where('user_id', '=', $searched_user[0]->id);
        }

    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

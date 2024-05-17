<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\comment;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
        ]);
        $category = Category::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $user->id,
            'category_id'=> $category->id,
        ]);
        Comment::factory(10)->create([
            'blog_id'=> $blog->id,
            'user_id' => 1,
        ]);
    }
}

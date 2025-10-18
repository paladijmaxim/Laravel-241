<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        \App\Models\User::factory(10)->create();
        \App\Models\Article::factory(10)->has(Comment::factory(3))->create();

        // Comment::query()->delete();
        // Article::query()->delete();
        // User::query()->delete();

        // $users = User::factory(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // $articles = Article::factory(30)->create([
        //     'user_id' => function() use ($users) { 
        //         return $users->random()->id;
        //     }
        // ]);

        // foreach ($articles as $article) {
        //     Comment::factory(rand(2, 4))->create([
        //         'article_id' => $article->id,
        //         'user_id' => $users->random()->id,
        //     ]);
        // }
        $this->call([
            UserSeeder::class,
        ]);
    }
}
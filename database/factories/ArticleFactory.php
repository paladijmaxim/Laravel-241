<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ArticleFactory extends Factory
{
    protected $model = \App\Models\Article::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'text' => fake()->text(500),
            'user_id' => User::factory(),
            'date_public' => fake()->date() 
        ];
    }
}
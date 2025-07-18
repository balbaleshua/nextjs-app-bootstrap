<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'slug' => $this->faker->slug,
            'summary' => $this->faker->text(100),
            'author_id' => \App\Models\User::factory(), // Assuming you have a User factory
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
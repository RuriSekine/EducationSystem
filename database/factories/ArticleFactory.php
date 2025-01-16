<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6, true),
        'posted_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        'article_contents' => $this->faker->paragraphs(3, true),
        'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $this->faker->dateTimeBetween('created_at', 'now'),
        ];
    }
}
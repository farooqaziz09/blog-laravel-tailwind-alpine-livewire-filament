<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = $this->faker->slug(3);

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $slug,
            // Faker's imageUrl() points at via.placeholder.com, which is offline; seed by slug for a stable unique image per post.
            'image' => "https://picsum.photos/seed/{$slug}/640/480",
            'body' => $this->faker->paragraph(10),
            // Mostly already published so / and /blog are populated after seeding. A few stay scheduled.
            'published_at' => $this->faker->boolean(85)
                ? $this->faker->dateTimeBetween('-2 months', '-1 hour')
                : $this->faker->dateTimeBetween('+1 day', '+2 weeks'),
            'featured' => $this->faker->boolean(20)
        ];
    }
}

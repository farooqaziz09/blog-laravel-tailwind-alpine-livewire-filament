<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Post::factory(100)->create();
        Category::factory(5)->create();

        // Local test login: test@example.com / password (admin, so /admin works too).
        // `role` is not mass-assignable, hence forceFill.
        User::firstOrNew(['email' => 'test@example.com'])->forceFill([
            'name' => 'Test User',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ])->save();
    }
}

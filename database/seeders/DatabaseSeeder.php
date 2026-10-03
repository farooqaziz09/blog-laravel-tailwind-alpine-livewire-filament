<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Post::factory(100)->create();
        Category::factory(5)->create();

        // Home "Featured" only lists published + featured posts. Random flags can miss that, so guarantee a few.
        if (Post::published()->featured()->count() < 3) {
            $ids = Post::published()
                ->where('featured', false)
                ->latest('published_at')
                ->take(3)
                ->pluck('id');

            Post::whereIn('id', $ids)->update(['featured' => true]);
        }

        // Drop a home-page cache that may have been filled with an empty list while tables were still empty.
        Cache::forget('featuredPosts');
        Cache::forget('latestPosts');
        Cache::forget('categories');

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

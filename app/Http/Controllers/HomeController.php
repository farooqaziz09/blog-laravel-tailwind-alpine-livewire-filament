<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $featuredPosts = $this->rememberPosts('featuredPosts', function () {
            return Post::published()->featured()->with('categories')->latest('published_at')->take(3)->get();
        });

        $latestPosts = $this->rememberPosts('latestPosts', function () {
            return Post::published()->with('categories')->latest('published_at')->take(9)->get();
        });

        return view('home', compact('featuredPosts', 'latestPosts'));
    }

    /**
     * An empty result is not stored. migrate:fresh --seed can be requested
     * mid-run, and a day-long cache of that empty list hides the new posts.
     */
    private function rememberPosts(string $key, \Closure $callback)
    {
        $posts = Cache::get($key);

        if ($posts === null || count($posts) === 0) {
            $posts = $callback();

            if (count($posts) > 0) {
                Cache::put($key, $posts, Carbon::now()->addDay());
            } else {
                Cache::forget($key);
            }
        }

        return $posts;
    }
}

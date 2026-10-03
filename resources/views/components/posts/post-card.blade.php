@props(['post'])
<div class="md:col-span-1 col-span-3">
  <a href="{{ route('post.show', $post->slug) }}">
    <div>
      <img class="w-full rounded-xl" src="{{ $post->getThumbnailImage() }}" alt="{{ $post->title }}">
    </div>
  </a>
  <div class="mt-3">
    <div class="flex items-center mb-2">
      @if ($category = $post->categories->first())
        <x-posts.category-badge :category="$category" />
      @endif
      <p class="text-gray-500 text-sm">{{ $post->published_at }}</p>
    </div>
    <a href="{{ route('post.show', $post->slug) }}" class="text-xl font-bold text-gray-900">
      {{ $post->title }}
    </a>
  </div>

</div>

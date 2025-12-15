<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12 pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Latest Posts</h1>
                <p class="mt-2 text-gray-600">Stay updated with our latest news and articles</p>
            </div>

            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            @if ($post->image)
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    <img src="{{ asset('storage/posts/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                                </a>
                            @endif
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->content), 150) }}
                                </p>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Read more →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 text-lg">No posts available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>


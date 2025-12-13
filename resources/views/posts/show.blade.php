<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if ($post->image)
                    <img src="{{ asset('storage/posts/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
                @endif
                
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        <div class="flex items-center mr-6">
                            <span class="font-medium">{{ $post->user->name }}</span>
                        </div>
                        <div>
                            <time datetime="{{ $post->published_at->toIso8601String() }}">
                                {{ $post->published_at->format('F d, Y') }}
                            </time>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            ← Back to all posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>


<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <!-- Profile Header -->
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" alt="{{ $user->username ?? $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                                <span class="text-4xl text-gray-600 font-semibold">
                                    {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $user->username ?? $user->name }}
                            </h1>
                            @if ($user->name && $user->username)
                                <p class="text-gray-600 mb-4">{{ $user->name }}</p>
                            @endif
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">{{ $user->posts()->published()->count() }}</span> published {{ Str::plural('post', $user->posts()->published()->count()) }}
                            </div>
                        </div>
                    </div>

                    <!-- About Me Section -->
                    @if ($user->about_me)
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-3">About</h2>
                            <p class="text-gray-700 whitespace-pre-line">{{ e($user->about_me) }}</p>
                        </div>
                    @endif

                    <!-- Posts Section -->
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                            Published Posts
                            @if ($posts->count() > 0)
                                <span class="text-lg font-normal text-gray-500">({{ $posts->total() }})</span>
                            @endif
                        </h2>

                        @if ($posts->count() > 0)
                            <div class="space-y-4">
                                @foreach ($posts as $post)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600">
                                                {{ e($post->title) }}
                                            </a>
                                        </h3>
                                        <div class="text-sm text-gray-500">
                                            <time datetime="{{ $post->published_at->toIso8601String() }}">
                                                {{ $post->published_at->format('F d, Y') }}
                                            </time>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No published posts yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>


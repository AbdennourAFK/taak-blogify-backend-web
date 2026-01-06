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

                    <!-- Like Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center gap-4">
                            @auth
                                @php
                                    $isLiked = $post->isLikedBy(auth()->user());
                                @endphp
                                <form method="POST" action="{{ route('posts.like', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 text-lg {{ $isLiked ? 'text-red-600' : 'text-gray-600 hover:text-red-600' }}">
                                        <span>{{ $isLiked ? '❤️' : '🤍' }}</span>
                                        <span>{{ $isLiked ? 'Unlike' : 'Like' }}</span>
                                    </button>
                                </form>
                            @else
                                <div class="flex items-center gap-2 text-gray-600">
                                    <span>❤️</span>
                                    <span>{{ $post->likes_count ?? 0 }} {{ Str::plural('like', $post->likes_count ?? 0) }}</span>
                                    <span class="text-sm text-gray-500 ml-2">(Log in to like this post)</span>
                                </div>
                            @endauth
                            
                            @auth
                                <div class="text-gray-600">
                                    <span class="font-medium">{{ $post->likes_count ?? 0 }}</span> {{ Str::plural('like', $post->likes_count ?? 0) }}
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Comments ({{ $post->comments->count() }})</h2>

                        @if (session('status'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Comment Form (Logged-in users only) -->
                        @auth
                            <div class="mb-6">
                                <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                                        <textarea 
                                            id="content" 
                                            name="content" 
                                            rows="3" 
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                            maxlength="1000"
                                        >{{ old('content') }}</textarea>
                                        @error('content')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Post Comment
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-gray-100 rounded-md text-center">
                                <p class="text-gray-600">Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">log in</a> to comment on this post.</p>
                            </div>
                        @endauth

                        <!-- Comments List -->
                        @if ($post->comments->count() > 0)
                            <div class="space-y-4">
                                @foreach ($post->comments as $comment)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center gap-3">
                                                <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y g:i A') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @auth
                                                    <form method="POST" action="{{ route('comments.save', $comment) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="{{ $comment->isSavedBy(auth()->user()) ? 'text-indigo-800 font-bold' : 'text-indigo-600 hover:text-indigo-800' }} text-sm">
                                                            {{ $comment->isSavedBy(auth()->user()) ? 'Saved' : 'Save' }}
                                                        </button>
                                                    </form>
                                                    @if ($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <p class="text-gray-700 whitespace-pre-wrap">{{ $comment->content }}</p>
                                        
                                        @auth
                                            @if ($comment->user_id !== auth()->id())
                                                <div class="mt-3">
                                                    <a href="{{ route('messages.show', $comment->user) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                                        Send private message
                                                    </a>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No comments yet. Be the first to comment!</p>
                            </div>
                        @endif
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


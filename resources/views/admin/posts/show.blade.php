<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Post
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.posts.edit', $post) }}">
                    <x-primary-button>
                        Edit Post
                    </x-primary-button>
                </a>
                <a href="{{ route('admin.posts.index') }}">
                    <x-secondary-button>
                        Back to List
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($post->image)
                        <div class="mb-6">
                            <img src="{{ asset('storage/posts/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg">
                        </div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <div class="mb-6 flex items-center gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">Author:</span> {{ $post->user->name }}
                        </div>
                        <div>
                            <span class="font-medium">Status:</span>
                            @if ($post->isPublished())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Published
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Draft
                                </span>
                            @endif
                        </div>
                        @if ($post->published_at)
                            <div>
                                <span class="font-medium">Published:</span> {{ $post->published_at->format('F d, Y g:i A') }}
                            </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Slug:</span>
                        <code class="ml-2 px-2 py-1 bg-gray-100 rounded text-sm">{{ $post->slug }}</code>
                    </div>

                    <div class="prose max-w-none text-gray-700 mb-6">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Edit Post
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-900">
                            Back to Posts List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


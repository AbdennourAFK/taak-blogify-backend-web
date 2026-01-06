<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Conversations</h1>

                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($conversations && $conversations->count() > 0)
                        <div class="space-y-4">
                            @foreach ($conversations as $conversation)
                                @if (isset($conversation['user']) && isset($conversation['last_message']))
                                    <a href="{{ route('messages.show', $conversation['user']) }}" class="block bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900">{{ $conversation['user']->name }}</h3>
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                                    {{ $conversation['last_message']->content }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-2">
                                                    {{ $conversation['last_message']->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            @if (isset($conversation['unread_count']) && $conversation['unread_count'] > 0)
                                                <span class="ml-4 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full">
                                                    {{ $conversation['unread_count'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <p class="text-lg">No conversations yet.</p>
                            <p class="text-sm mt-2">Start a conversation by commenting on a post and messaging another user.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


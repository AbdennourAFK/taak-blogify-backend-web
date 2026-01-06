<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conversation with ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ route('messages.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            ← Back to conversations
                        </a>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Conversation with {{ $user->name }}</h1>

                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Messages List -->
                    <div class="mb-6 space-y-4 max-h-96 overflow-y-auto">
                        @if ($messages->count() > 0)
                            @foreach ($messages->reverse() as $message)
                                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-900' }}">
                                        <div class="text-sm font-medium mb-1">
                                            {{ $message->sender->name }}
                                        </div>
                                        <div class="text-sm whitespace-pre-wrap">{{ $message->content }}</div>
                                        <div class="text-xs mt-1 opacity-75">
                                            {{ $message->created_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No messages yet. Start the conversation!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Message Form -->
                    <div class="border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('messages.store', $user) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Send a message</label>
                                <textarea 
                                    id="content" 
                                    name="content" 
                                    rows="3" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                    maxlength="2000"
                                    placeholder="Type your message here..."
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






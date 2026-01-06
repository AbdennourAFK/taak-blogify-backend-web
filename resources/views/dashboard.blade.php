@php
    // Automatically select layout based on user role
    $layout = auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.user';
@endphp

@extends($layout)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                <span class="text-2xl text-gray-600 font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Welcome back, {{ $user->name }}!</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $user->isAdmin() ? 'Administrator' : 'User' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->isAdmin())
                <!-- Admin Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Panel</h3>
                        <p class="text-gray-600 mb-4">Manage content and settings from the admin panel.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Manage Posts
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.faq-categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Manage FAQ Categories
                            </a>
                            <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Manage FAQs
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Regular User Dashboard -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">User Dashboard</h3>
                        <div class="flex flex-wrap gap-3 mb-6">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Profile
                            </a>
                            <a href="{{ route('profile.show', $user) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Public Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User's Latest Posts -->
                @if(isset($userPosts) && $userPosts->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Latest Posts</h3>
                            <div class="space-y-3">
                                @foreach($userPosts as $post)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="text-base font-medium text-gray-900 mb-1">
                                                    {{ $post->title }}
                                                </h4>
                                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                                    <span>
                                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                                                    </span>
                                                    <span>•</span>
                                                    @if($post->isPublished())
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Published
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Draft
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(isset($totalPostsCount) && $totalPostsCount > 5)
                                <div class="mt-4">
                                    <a href="{{ route('profile.show', $user) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        View all {{ $totalPostsCount }} posts →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif(isset($userPosts) && $userPosts->count() === 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Latest Posts</h3>
                            <div class="text-center py-8 text-gray-500">
                                <p>You haven't created any posts yet.</p>
                                <p class="text-sm mt-2">Posts you create will appear here.</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

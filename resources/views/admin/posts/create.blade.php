<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="15" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Featured Image')" />
                            <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Max 2MB. Allowed formats: JPEG, PNG, JPG, GIF</p>
                        </div>

                        <!-- Published At -->
                        <div class="mt-4">
                            <x-input-label for="published_at" :value="__('Publish Date (optional)')" />
                            <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at" :value="old('published_at')" />
                            <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Leave empty to save as draft</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                FAQ Details
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Category</h3>
                        <p class="text-gray-700">{{ $faq->category->name }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Question</h3>
                        <p class="text-gray-700 text-lg">{{ $faq->question }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Answer</h3>
                        <div class="text-gray-700 whitespace-pre-line">{{ $faq->answer }}</div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Created: {{ $faq->created_at->format('F d, Y \a\t g:i A') }}<br>
                            Last updated: {{ $faq->updated_at->format('F d, Y \a\t g:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


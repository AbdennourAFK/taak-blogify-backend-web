<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                FAQ Category: {{ $faqCategory->name }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.faq-categories.edit', $faqCategory) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('admin.faq-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Name</h3>
                        <p class="text-gray-700">{{ $faqCategory->name }}</p>
                    </div>

                    @if ($faqCategory->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700">{{ $faqCategory->description }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Slug</h3>
                        <p class="text-gray-700">{{ $faqCategory->slug }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">FAQs in this Category ({{ $faqCategory->faqs->count() }})</h3>
                        @if ($faqCategory->faqs->count() > 0)
                            <div class="space-y-3">
                                @foreach ($faqCategory->faqs as $faq)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-900 mb-2">{{ $faq->question }}</h4>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($faq->answer, 150) }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Edit FAQ →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No FAQs in this category yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12 pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Frequently Asked Questions</h1>
                <p class="mt-2 text-gray-600">Find answers to common questions</p>
            </div>

            @if ($categories->count() > 0)
                <div class="space-y-8">
                    @foreach ($categories as $category)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                                    {{ $category->name }}
                                </h2>
                                @if ($category->description)
                                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                                @endif

                                <div class="space-y-4">
                                    @foreach ($category->faqs as $faq)
                                        <div class="border-l-4 border-indigo-500 pl-4">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                {{ $faq->question }}
                                            </h3>
                                            <p class="text-gray-700 whitespace-pre-line">
                                                {{ $faq->answer }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 text-lg">No FAQs available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>


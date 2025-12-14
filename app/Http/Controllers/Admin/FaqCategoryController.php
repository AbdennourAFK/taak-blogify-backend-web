<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = FaqCategory::withCount('faqs')
            ->latest()
            ->paginate(15);

        return view('admin.faq-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.faq-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate slug from name
        $validated['slug'] = FaqCategory::generateSlug($validated['name']);

        FaqCategory::create($validated);

        return redirect()->route('admin.faq-categories.index')
            ->with('status', 'FAQ category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqCategory $faqCategory): View
    {
        $faqCategory->load('faqs');
        return view('admin.faq-categories.show', compact('faqCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqCategory $faqCategory): View
    {
        return view('admin.faq-categories.edit', compact('faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqCategoryRequest $request, FaqCategory $faqCategory): RedirectResponse
    {
        $validated = $request->validated();

        // Generate new slug if name changed
        if ($faqCategory->name !== $validated['name']) {
            $validated['slug'] = FaqCategory::generateSlug($validated['name']);
        }

        $faqCategory->update($validated);

        return redirect()->route('admin.faq-categories.index')
            ->with('status', 'FAQ category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faqCategory): RedirectResponse
    {
        $faqCategory->delete();

        return redirect()->route('admin.faq-categories.index')
            ->with('status', 'FAQ category deleted successfully.');
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs grouped by category.
     */
    public function index(): View
    {
        $categories = FaqCategory::with('faqs')
            ->has('faqs')
            ->orderBy('name')
            ->get();

        return view('faq.index', compact('categories'));
    }
}


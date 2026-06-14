<?php

use App\Models\ProductKnowledge;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $productKnowledges = ProductKnowledge::query()
        ->where('is_active', true)
        ->orderBy('order', 'asc')
        ->get();

    return view('welcome', compact('productKnowledges'));
});

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('set-locale');

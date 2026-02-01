<?php

use App\Livewire\ArticleDetail;
use App\Livewire\CategoryPage;
use App\Livewire\Home;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', Home::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/news/{slug}', ArticleDetail::class)->name('article.show');
Route::get('/category/{slug}', CategoryPage::class)->name('category.show');


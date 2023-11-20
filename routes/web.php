<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\GptStoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [StoryController::class, 'home'])->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Routes that should have the 'can:manage' middleware
Route::get('stories/create', [StoryController::class, 'create'])->middleware('can:manage')->name('stories.create');
Route::get('stories/{story}/edit', [StoryController::class, 'edit'])->middleware('can:manage')->name('stories.edit');
Route::post('stories', [StoryController::class, 'store'])->middleware('can:manage')->name('stories.store');
Route::put('stories/{story}', [StoryController::class, 'update'])->middleware('can:manage')->name('stories.update');
Route::delete('stories/{story}', [StoryController::class, 'destroy'])->middleware('can:manage')->name('stories.destroy');
Route::get('/generate-story', [StoryController::class, 'generateStory'])->name('generate.story')->middleware('auth');

Route::post('/generate-story', [StoryController::class, 'generate'])->name('generate.story')->middleware('auth');
//resource to GptStoryController
Route::resource('gptstories', GptStoryController::class)->middleware(['auth', 'verified']);

// The rest of the resource routes
Route::resource('stories', StoryController::class)->middleware(['auth', 'verified'])->except(['create', 'edit', 'store', 'update', 'destroy']);

//coming-soon
Route::get('/coming-soon', function () {return view('coming-soon');})->name('coming-soon');

//logout
Route::POST('/logout', function () {Auth::logout();return redirect('/');})->name('logout');

//contact
Route::get('/contact', function () {return view('contact');})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
require __DIR__.'/auth.php';

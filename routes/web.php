<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

// Route::redirect(Route::current(), app()->currentLocale());

Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lang', [HomeController::class, 'lang'])->name('lang');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/events', [HomeController::class, 'events'])->name('events');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});





require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\StarWars\MovieController;
use App\Http\Controllers\StarWars\PersonController;
use App\Http\Controllers\StarWars\SearchController;
use App\Http\Controllers\StarWars\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WelcomeController::class, 'welcome'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

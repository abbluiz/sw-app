<?php

use App\Http\Controllers\StarWars\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/statistics', [StatisticsController::class, 'statistics'])->name('statistics');

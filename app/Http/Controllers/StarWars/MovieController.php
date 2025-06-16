<?php

namespace App\Http\Controllers\StarWars;

use Inertia\Inertia;
use App\Models\Movie;
use Inertia\Response;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    public function show(string|int $id): Response
    {
        return Inertia::render('movies/show', ['movie' => Movie::find($id)]);
    }
}

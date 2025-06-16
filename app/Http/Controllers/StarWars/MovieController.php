<?php

namespace App\Http\Controllers\StarWars;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    public function show(string|int $id): Response
    {
        $result = app(MovieService::class)->showAndSave($id, true);

        return Inertia::render('movies/show', ['movie' => [
            ...$result->toArray(),
            'people' => $result->people
        ]]);
    }
}

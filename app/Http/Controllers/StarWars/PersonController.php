<?php

namespace App\Http\Controllers\StarWars;

use App\Http\Controllers\Controller;
use App\Services\PersonService;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    public function show(string|int $id): Response
    {
        $result = app(PersonService::class)->showAndSave($id, true);

        return Inertia::render('people/show', ['person' => [
            ...$result->toArray(),
            'movies' => $result->movies
        ]]);
    }
}

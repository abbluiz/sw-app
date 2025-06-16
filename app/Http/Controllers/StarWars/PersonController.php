<?php

namespace App\Http\Controllers\StarWars;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Person;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
    public function show(string|int $id): Response
    {
        return Inertia::render('people/show', ['person' => Person::find($id)]);
    }
}

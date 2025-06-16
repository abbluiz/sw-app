<?php

namespace App\Http\Controllers\StarWars;

use Inertia\Inertia;
use Inertia\Response;
use App\Enums\SearchMode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\MovieRepository;
use App\Repositories\PersonRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function search(Request $request): RedirectResponse|Response
    {
        $validator = Validator::make($request->query(), [
            'mode' => ['string', Rule::enum(SearchMode::class)],
            'query' => ['string', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mode = $request->query('mode');
        $query = $request->query('query');

        $people = collect([]);
        $movies = collect([]);

        if ($mode === 'people') {
            $people = new PersonRepository()->allAndSave($query);
        }

        if ($mode === 'movies') {
            $movies = new MovieRepository()->allAndSave($query);
        }

        return Inertia::render(
            component: 'search',
            props: [
                'people' => $people->all(),
                'movies' => $movies->all()
            ]
        );
    }
}

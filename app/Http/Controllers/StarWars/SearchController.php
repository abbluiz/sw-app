<?php

namespace App\Http\Controllers\StarWars;

use Inertia\Inertia;
use App\Models\Query;
use Inertia\Response;
use App\Enums\SearchMode;
use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Services\PersonService;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
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
            $people = app(PersonService::class)->indexAndSave($query);
        }

        if ($mode === 'movies') {
            $movies = app(MovieService::class)->indexAndSave($query);
        }

        if (! empty($query)) {
            Query::create([...$request->query()]);
        }

        return Inertia::render(
            component: 'search',
            props: [
                'people' => $people->all(),
                'movies' => $movies->all(),
            ]
        );
    }
}

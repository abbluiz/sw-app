<?php

namespace App\Services\External\StarWarsApi\Resources;

use Illuminate\Support\Collection;
use App\Models\Movie as EloquentMovie;
use App\Services\External\StarWarsApi\DataObjects\Movie;
use App\Services\External\StarWarsApi\StarWarsApiService;
use App\Services\External\StarWarsApi\DataFactories\MovieFactory;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MovieResource
{
    public function __construct(
        private readonly StarWarsApiService $service,
    ) {
    }

    public function show(
        string $identifier
    ): ?Movie {
        $url = "/films/{$identifier}/";

        $request = $this->service->buildRequest()->getRequest();

        $response = $this->service->get(request: $request, url: $url);

        if ($response->successful()) {
            return MovieFactory::new($response->json());
        }

        return null;
    }

    /**
     * @return ?Collection<int, Movie>
     */
    public function index(
        ?string $searchParam = null
    ): ?Collection {
        $url = "/films/";

        if (!empty($searchParam)) {
            $url = $url . "?search=$searchParam";
        }

        $request = $this->service
            ->getRequest();

        $response = $this->service->get($request, $url);

        if ($response->successful()) {
            $resources = $response->json('results') ?? [];

            return MovieFactory::collection($resources);
        }

        return null;
    }

    public function indexAndSave(
        ?string $searchParam = null
    ): void {
        $results = $this->index($searchParam);

        $results->each(function (Movie $item, int $key) {
            $re = '/films\/(\d+)/m';
            preg_match_all($re, $item->url, $matches, PREG_SET_ORDER, 0);

            $id = intval($matches[0][1]);

            EloquentMovie::query()->updateOrCreate(
                attributes: ['id' => $id],
                values: [
                    'id' => $id,
                    ...$item->toArray()
                ]
            );
        });
    }
}

<?php

namespace App\Services\External\StarWarsApi\Resources;

use Illuminate\Support\Collection;
use App\Services\External\StarWarsApi\DataObjects\Movie;
use App\Services\External\StarWarsApi\StarWarsApiService;
use App\Services\External\StarWarsApi\DataFactories\MovieFactory;

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
}

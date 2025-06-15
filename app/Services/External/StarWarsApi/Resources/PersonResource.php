<?php

namespace App\Services\External\StarWarsApi\Resources;

use App\Services\External\StarWarsApi\DataObjects\Person;
use App\Services\External\StarWarsApi\StarWarsApiService;
use App\Services\External\StarWarsApi\DataFactories\PersonFactory;
use Illuminate\Support\Collection;

class PersonResource
{
    public function __construct(
        private readonly StarWarsApiService $service,
    ) {
    }

    public function show(
        string $identifier
    ): ?Person {
        $url = "/people/{$identifier}";

        $request = $this->service->buildRequest()->getRequest();

        $response = $this->service->get(request: $request, url: $url);

        if ($response->successful()) {
            return PersonFactory::new($response->json());
        }

        return null;
    }

    /**
     * @return ?Collection<int, Person>
     */
    public function index(
        ?string $searchParam = null
    ): ?Collection {
        $url = "/people";

        if (!empty($searchParam)) {
            $url = $url . "?search=$searchParam";
        }

        $request = $this->service
            ->getRequest();

        $response = $this->service->get($request, $url);

        if ($response->successful()) {
            $resources = $response->json('results') ?? [];

            return PersonFactory::collection($resources);
        }

        return null;
    }
}

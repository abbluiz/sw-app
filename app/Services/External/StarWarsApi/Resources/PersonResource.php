<?php

namespace App\Services\External\StarWarsApi\Resources;

use App\Jobs\SyncPersonRelation;
use App\Models\Person as EloquentPerson;
use App\Services\External\StarWarsApi\DataFactories\PersonFactory;
use App\Services\External\StarWarsApi\DataObjects\Person;
use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PersonResource
{
    public function __construct(
        private readonly StarWarsApiService $service,
    ) {}

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
        $url = '/people';

        if (! empty($searchParam)) {
            $url = $url."?search=$searchParam";
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

    public function showAndSave(
        int|string $identifier
    ): void {
        $result = $this->show($identifier);

        if (! empty($result)) {
            $entity = EloquentPerson::query()->updateOrCreate(
                attributes: ['id' => $identifier],
                values: [
                    'id' => $identifier,
                    'mass_in_kg' => $result->mass,
                    'height_in_cm' => $result->height,
                    ...$result->toArray(),
                ]
            );

            Arr::map($result->movieUrls, function (string $movieUrl) use ($entity) {
                $re = '/films\/(\d+)/m';
                preg_match_all($re, $movieUrl, $matches, PREG_SET_ORDER, 0);

                $id = intval($matches[0][1]);

                SyncPersonRelation::dispatch($entity, $id);

                return $id;
            });
        }
    }

    public function indexAndSave(
        ?string $searchParam = null
    ): void {
        $results = $this->index($searchParam);

        $results->each(function (Person $item, int $key) {
            $re = '/people\/(\d+)/m';
            preg_match_all($re, $item->url, $matches, PREG_SET_ORDER, 0);

            $id = intval($matches[0][1]);

            $entity = EloquentPerson::query()->updateOrCreate(
                attributes: ['id' => $id],
                values: [
                    'id' => $id,
                    'mass_in_kg' => $item->mass,
                    'height_in_cm' => $item->height,
                    ...$item->toArray(),
                ]
            );

            Arr::map($item->movieUrls, function (string $movieUrl) use ($entity) {
                $re = '/films\/(\d+)/m';
                preg_match_all($re, $movieUrl, $matches, PREG_SET_ORDER, 0);

                $id = intval($matches[0][1]);

                SyncPersonRelation::dispatch($entity, $id);

                return $id;
            });
        });
    }
}

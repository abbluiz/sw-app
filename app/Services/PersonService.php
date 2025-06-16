<?php

namespace App\Services;

use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Database\Eloquent\Collection;

class PersonService
{
    public function __construct(
        private PersonRepository $repository,
        private StarWarsApiService $apiService
    ) {}

    public function showAndSave(
        string|int $identifier,
        bool $failIfNotFound = false
    ): ?Person {
        $result = $this->repository->find($identifier);

        if (empty($result)) {
            $this->apiService
                ->person()
                ->showAndSave($identifier);

            return $this->repository->find($identifier, $failIfNotFound);
        }

        return $result;
    }

    /**
     * @return Collection<int, Person>
     */
    public function indexAndSave(?string $param = null): Collection
    {
        $results = $this->repository->all($param);

        if ($results->isEmpty()) {
            $this->apiService
                ->person()
                ->indexAndSave($param);

            return $this->repository->all($param);
        }

        return $results;
    }
}

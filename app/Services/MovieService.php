<?php

namespace App\Services;

use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Database\Eloquent\Collection;

class MovieService
{
    public function __construct(
        private MovieRepository $repository,
        private StarWarsApiService $apiService
    ) {}

    public function showAndSave(
        string|int $identifier,
        bool $failIfNotFound = false
    ): ?Movie {
        $result = $this->repository->find($identifier);

        if (empty($result)) {
            $this->apiService
                ->movie()
                ->showAndSave($identifier);

            return $this->repository->find($identifier, $failIfNotFound);
        }

        return $result;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function indexAndSave(?string $param = null): Collection
    {
        $results = $this->repository->all($param);

        if ($results->isEmpty()) {
            $this->apiService
                ->movie()
                ->indexAndSave($param);

            return $this->repository->all($param);
        }

        return $results;
    }
}

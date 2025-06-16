<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository
{
    public function all(?string $param = null): Collection
    {
        $results = collect([]);

        if (empty($param)) {
            $results = Movie::all();
        } else {
            $results = Movie::query()->where('title', 'ilike', "%$param%")->get();
        }

        return $results;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function allAndSave(?string $param = null): Collection
    {
        $results = $this->all($param);

        if ($results->isEmpty()) {
            new StarWarsApiService()
                ->movie()
                ->indexAndSave($param);

            return $this->all($param);
        }

        return $results;
    }
}

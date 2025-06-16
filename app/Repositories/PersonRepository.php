<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use App\Services\External\StarWarsApi\StarWarsApiService;

class PersonRepository
{
    public function all(?string $param = null): Collection
    {
        $results = collect([]);

        if (empty($param)) {
            $results = Person::all();
        } else {
            $results = Person::query()->where('name', 'ilike', "%$param%")->get();
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
                ->person()
                ->indexAndSave($param);

            return $this->all($param);
        }

        return $results;
    }
}

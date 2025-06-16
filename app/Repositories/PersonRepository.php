<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class PersonRepository
{
    public function find(
        string|int $identifier,
        bool $failIfNotFound = false
    ): ?Person {
        if ($failIfNotFound) {
            return Person::query()->findOrFail($identifier);
        }

        return Person::query()->find($identifier);
    }

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
}

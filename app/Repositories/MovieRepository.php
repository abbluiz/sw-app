<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository
{
    public function find(
        string|int $identifier,
        bool $failIfNotFound = false
    ): ?Movie {
        if ($failIfNotFound) {
            return Movie::query()->findOrFail($identifier);
        }

        return Movie::query()->find($identifier);
    }

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
}

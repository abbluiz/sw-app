<?php

namespace App\Services\External\StarWarsApi\DataFactories;

use App\Services\External\StarWarsApi\DataObjects\Movie;
use Illuminate\Support\Collection;

final class MovieFactory
{
    /**
     * @param array<string, mixed>[] $movies
     * @return Collection<int, Movie>
     */
    public static function collection(array $movies): Collection
    {
        return (new Collection(items: $movies))
            ->map(fn ($movie): Movie => static::new(attributes: $movie));
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function new(mixed $attributes): Movie
    {
        return (new self())->make(
            attributes: $attributes
        );
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function make(mixed $attributes): Movie
    {
        return new Movie(
            url: strval(data_get($attributes, 'url')),
            title: strval(data_get($attributes, 'title')),
            openingCrawl: strval(data_get($attributes, 'opening_crawl')),
            personUrls: data_get($attributes, 'characters') ?? []
        );
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function fake(
        array $attributes = [],
    ): Movie {
        return static::new([
            'url' => $attributes['url'] ?? fake()->url(),
            'title' => $attributes['title'] ?? fake()->word(),
            'opening_crawl' => $attributes['opening_crawl'] ?? fake()->paragraphs(),
            'person_urls' => $attributes['person_urls'] ?? [fake()->url()],
        ]);
    }

    /**
     * @param array<string, mixed>[] $movies
     * @return Collection<int, Movie>
     */
    public static function fakeCollection(
        int $count = 1,
        array $movies = []
    ): Collection {
        $overrideMockedData = false;

        if (! empty($movies)) {
            $count = count($movies);
            $overrideMockedData = true;
        } elseif ($count <= 0) {
            $count = 1;
        }

        $mockedData = array();

        for ($i = 0; $i < $count; $i++) {
            if (! $overrideMockedData) {
                $mockedData[] = static::fake()->toArray();
            } else {
                $mockedData[] = static::fake([
                    'url' => $movies[$i]['url'] ?? null,
                    'title' => $movies[$i]['title'] ?? null,
                    'opening_crawl' => $movies[$i]['opening_crawl'] ?? null,
                    'person_urls' => $movies[$i]['person_urls'] ?? null,
                ])->toArray();
            }
        }

        return static::collection($mockedData);
    }

    /**
     * @param array<string, mixed>[] $movies
     * @return array<int, array<string, mixed>>
     */
    public static function fakeArray(
        int $count = 1,
        array $movies = []
    ): array {
        return static::fakeCollection($count, $movies)
            ->map(function (Movie $item, int $key) {
                return $item->toArray();
            })->toArray();
    }
}

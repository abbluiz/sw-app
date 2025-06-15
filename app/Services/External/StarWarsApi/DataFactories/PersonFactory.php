<?php

namespace App\Services\External\StarWarsApi\DataFactories;

use App\Enums\Gender;
use Illuminate\Support\Collection;
use App\Services\External\StarWarsApi\DataObjects\Person;

final class PersonFactory
{
    /**
     * @param array<array<string, mixed>> $people
     * @return Collection<int, Person>
     */
    public static function collection(array $people): Collection
    {
        return (new Collection(items: $people))
            ->map(fn ($person): Person => static::new(attributes: $person));
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function new(mixed $attributes): Person
    {
        return (new self())->make(
            attributes: $attributes
        );
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function make(mixed $attributes): Person
    {
        return new Person(
            url: strval(data_get($attributes, 'url')),
            name: strval(data_get($attributes, 'name')),
            gender: strval(data_get($attributes, 'gender')),
            eyeColor: strval(data_get($attributes, 'eye_color')),
            hairColor: strval(data_get($attributes, 'hair_color')),
            height: strval(data_get($attributes, 'height')),
            mass: strval(data_get($attributes, 'mass')),
            movieUrls: data_get($attributes, 'films') ?? []
        );
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function fake(array $attributes = []): Person
    {
        return static::new([
            'url' => $attributes['url'] ?? fake()->url(),
            'name' => $attributes['name'] ?? fake()->name(),
            'gender' => $attributes['gender'] ?? fake()->randomElement(Gender::values()),
            'eye_color' => $attributes['eye_color'] ?? fake()->colorName(),
            'hair_color' => $attributes['hair_color'] ?? fake()->colorName(),
            'height' => $attributes['height'] ?? fake()->numberBetween(1, 200),
            'mass' => $attributes['mass'] ?? fake()->numberBetween(1, 200),
            'movie_urls' => $attributes['movie_urls'] ?? [fake()->url()]
        ]);
    }

    /**
     * @param array<string, mixed>[] $people
     * @return Collection<int, Person>
     */
    public static function fakeCollection(
        int $count = 1,
        array $people = []
    ): Collection {
        $overrideMockedData = false;

        if (! empty($people)) {
            $count = count($people);
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
                    'url' => $people[$i]['url'] ?? null,
                    'name' => $people[$i]['name'] ?? null,
                    'gender' => $people[$i]['gender'] ?? null,
                    'eye_color' => $people[$i]['eye_color'] ?? null,
                    'hair_color' => $people[$i]['hair_color'] ?? null,
                    'height' => $people[$i]['height'] ?? null,
                    'mass' => $people[$i]['mass'] ?? null,
                    'movie_urls' => $people[$i]['movie_urls'] ?? null,
                ])->toArray();
            }
        }

        return static::collection($mockedData);
    }

    /**
     * @param array<string, mixed>[] $people
     * @return array<int, array<string, mixed>>
     */
    public static function fakeArray(
        int $count = 1,
        array $people = []
    ): array {
        return static::fakeCollection($count, $people)
            ->map(function (Person $item, int $key) {
                return $item->toArray();
            })->toArray();
    }
}

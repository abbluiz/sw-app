<?php

namespace App\Services\External\StarWarsApi\DataObjects;

class Person
{
    /**
     * @param  string[]  $movieUrls
     */
    public function __construct(
        public readonly string $url,
        public readonly string $name,
        public readonly string $birthYear,
        public readonly string $gender,
        public readonly string $eyeColor,
        public readonly string $hairColor,
        public readonly string $height,
        public readonly string $mass,
        public readonly array $movieUrls = [],
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'name' => $this->name,
            'birth_year' => $this->birthYear,
            'gender' => $this->gender,
            'eye_color' => $this->eyeColor,
            'hair_color' => $this->hairColor,
            'height' => $this->height,
            'mass' => $this->mass,
            'movie_urls' => $this->movieUrls,
        ];
    }
}

<?php

namespace App\Services\External\StarWarsApi\DataObjects;

class Movie
{
    /**
     * @param  string[]  $personUrls
     */
    public function __construct(
        public readonly string $url,
        public readonly string $title,
        public readonly string $openingCrawl,
        public readonly array $personUrls = []
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'title' => $this->title,
            'opening_crawl' => $this->openingCrawl,
            'person_urls' => $this->personUrls,
        ];
    }
}

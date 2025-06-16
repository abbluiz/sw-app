<?php

namespace App\Services\External\StarWarsApi\Concerns;

use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

trait BuildsBaseRequests
{
    public function withBaseUrl(?string $acceptContentType = null): PendingRequest
    {
        return Http::baseUrl(
            url: empty($this->pathPrefix)
                ? $this->baseUrl
                : $this->baseUrl.$this->pathPrefix,
        )->accept($acceptContentType ?? $this->acceptContentType);
    }

    public function buildRequest(?string $acceptContentType = null): StarWarsApiService
    {
        $this->request = $this->withBaseUrl($acceptContentType);

        return $this;
    }
}

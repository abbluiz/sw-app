<?php

namespace App\Services\External\StarWarsApi\Concerns;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use App\Services\External\StarWarsApi\StarWarsApiService;

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

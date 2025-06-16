<?php

namespace App\Services\External\StarWarsApi;

use App\Services\External\StarWarsApi\Concerns\BuildsBaseRequests;
use App\Services\External\StarWarsApi\Concerns\CanSendGetRequests;
use App\Services\External\StarWarsApi\Concerns\CanThrowExceptions;
use App\Services\External\StarWarsApi\Resources\MovieResource;
use App\Services\External\StarWarsApi\Resources\PersonResource;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class StarWarsApiService
{
    use BuildsBaseRequests;
    use CanSendGetRequests;
    use CanThrowExceptions;

    private ?PendingRequest $request = null;

    private ?Response $response = null;

    public function __construct(
        private ?string $baseUrl = null,
        private bool $throwsExceptions = false,
        private array $exemptErrorCodes = [],
        private string $acceptContentType = 'application/json',
    ) {
        $this->baseUrl = $baseUrl ?? config('services.star_wars_api.base_url');
    }

    public function getRequest(): PendingRequest
    {
        return $this->request ?? $this->withBaseUrl();
    }

    public function getResponse(
        ?bool $throwsExceptions = null,
        ?array $exemptErrorCodes = null
    ): ?Response {
        return ($throwsExceptions ?? $this->throwsExceptions)
            ? $this->throwExceptions(
                exemptErrorCodes: $exemptErrorCodes ?? $this->exemptErrorCodes
            )->response
            : $this->response;
    }

    public function person(): PersonResource
    {
        /** @var PersonResource $personResource */
        $personResource = app(PersonResource::class, ['service' => $this]);

        return $personResource;
    }

    public function movie(): MovieResource
    {
        /** @var MovieResource $movieResource */
        $movieResource = app(MovieResource::class, ['service' => $this]);

        return $movieResource;
    }
}

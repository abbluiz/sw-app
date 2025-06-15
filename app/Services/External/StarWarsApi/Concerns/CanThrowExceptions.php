<?php

namespace App\Services\External\StarWarsApi\Concerns;

use App\Exceptions\ExternalServiceCommunicationException;
use App\Services\External\StarWarsApi\StarWarsApiService;

trait CanThrowExceptions
{
    public function throwExceptions(
        array $exemptErrorCodes = []
    ): StarWarsApiService {
        if ($this->response->failed() && ! in_array($this->response->status(), $exemptErrorCodes)) {
            throw new ExternalServiceCommunicationException(service: $this, response: $this->response);
        }

        return $this;
    }
}

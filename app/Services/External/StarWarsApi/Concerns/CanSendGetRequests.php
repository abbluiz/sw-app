<?php

namespace App\Services\External\StarWarsApi\Concerns;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

trait CanSendGetRequests
{
    public function get(PendingRequest $request, string $url): Response
    {
        $this->response = $request->get(
            url: $url
        );

        return $this->response;
    }
}

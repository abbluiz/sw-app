<?php

namespace App\Exceptions;

use App\Services\External\StarWarsApi\StarWarsApiService;
use Illuminate\Http\Client\Response;

class ExternalServiceCommunicationException extends \Exception
{
    public function __construct(
        ?StarWarsApiService $service = null,
        ?Response $response = null
    ) {
        if (empty($service) || empty($response)) {
            parent::__construct(trans('Error while communicating with an external service.'));
        } else {
            $mainMessage = trans(key: 'Error while communicating with :service during HTTP :verb request for :url.', replace: [
                'service' => class_basename($service),
                'verb' => $response->transferStats?->getRequest()?->getMethod(),
                'url' => (string) $response->transferStats?->getEffectiveUri(),
            ]);

            $statusMessage = trans(key: 'Status code was :code.', replace: ['code' => $response->status()]);

            parent::__construct("{$mainMessage} {$statusMessage}");
        }
    }
}

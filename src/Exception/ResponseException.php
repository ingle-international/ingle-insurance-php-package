<?php

namespace Ingle\Insurance\Api\Exception;

use Psr\Http\Message\ResponseInterface;

class ResponseException extends \Exception
{
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getStatusCode().': '.$response->getReasonPhrase()."\n".
            json_encode(json_decode($response->getBody(), true), JSON_PRETTY_PRINT)."\n");
    }
}

<?php

namespace Ingle\Insurance\Api\Exception;

use Psr\Http\Message\ResponseInterface;

class BadRequestException extends \Exception
{
    private $errors = [];

    public function __construct(ResponseInterface $response)
    {
        $this->errors = json_decode($response->getBody(), true);

        parent::__construct(json_encode($this->errors, JSON_PRETTY_PRINT));
    }

    public function getErrorMessages()
    {
        return $this->errors['messages'];
    }

    public function getErrorId()
    {
        return $this->errors['id'];
    }
}

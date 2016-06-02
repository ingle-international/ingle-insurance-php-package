<?php

namespace Ingle\Insurance\Api\Exception;

class AuthenticationException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Client is not authenticated. API key might not be set correctly.');
    }
}

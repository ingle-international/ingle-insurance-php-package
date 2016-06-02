<?php

namespace Ingle\Insurance\Api\Exception;

class ServerException extends \Exception
{
    public function __construct($uri)
    {
        parent::__construct('Server timed out at '.$uri);
    }
}

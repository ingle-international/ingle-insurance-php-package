<?php

namespace Ingle\Insurance\Api;

use Ingle\Insurance\Api\Exception\DataException;

abstract class Base
{
    protected $client;
    protected $data = [];
    protected $source = '';

    /**
     * Create Object with set source and client.
     */
    public function __construct()
    {
        $this->client = IngleInsurance::getClient();
        $this->source = IngleInsurance::getSource();

        if ($this->source == null) {
            throw new DataException('Tried to make '.get_class($this).' without source.');
        }
    }

    /**
     * Returns json representation of changed data.
     *
     * @return string json representation of data array
     */
    public function __toString()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}

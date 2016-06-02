<?php

namespace Ingle\Insurance\Api;

class Quote extends Base
{
    /**
     * Create Quote for specified application.
     *
     * @param $applicationId
     */
    public function __construct($applicationId)
    {
        parent::__construct();

        $this->data = $this->client->get(sprintf('quote/%s/%s', $this->source, $applicationId));
    }

    /**
     * Get total price of quote.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->data['quote']['price'];
    }

    /**
     * Get brief info about quote.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->data['quote']['information'];
    }

    /**
     * Get details of application quote.
     *
     * @return array
     */
    public function getContent()
    {
        return $this->data['content'];
    }

    /**
     * Get links of quote.
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->data['links'];
    }
}

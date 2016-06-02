<?php

namespace Ingle\Insurance\Api;

class Confirmation extends Base
{
    protected $data = [];

    /**
     * Create payment confirmation with given data.
     *
     * @param $applicationId
     *
     * @throws Exception\DataException
     */
    public function __construct($applicationId)
    {
        parent::__construct();

        $this->data = $this->client->get(sprintf('confirmation/%s/%s', IngleInsurance::getSource(), $applicationId));
    }

    /**
     * Return title of payment confirmation.
     *
     * @return string title
     */
    public function getTitle()
    {
        return $this->data['title'];
    }

    /**
     * Return title of payment confirmation.
     *
     * @return string header
     */
    public function getHeader()
    {
        return $this->data['header_text'];
    }

    /**
     * Return body of payment confirmation.
     *
     * @return array body
     */
    public function getBody()
    {
        return $this->data['body'];
    }

    /**
     * Return legal text in payment confirmation.
     *
     * @return string text
     */
    public function getLegalText()
    {
        return $this->data['legal_text'];
    }
}

<?php

namespace Ingle\Insurance\Api\Client;

interface BaseClient
{
    /**
     * Get authorization token using given key.
     *
     * @param $key
     */
    public function setApiKey($key);

    /**
     * Send a POST request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @return array response data
     */
    public function post($uri, array $data);

    /**
     * Send a GET request to the specified URI.
     *
     * @param $uri
     *
     * @return array response data
     */
    public function get($uri);

    /**
     * Send a DELETE request to the specified URI.
     *
     * @param $uri
     *
     * @return array response data
     */
    public function delete($uri);

    /**
     * Send a PUT request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @return array response data
     */
    public function put($uri, array $data);

    /**
     * Send a PATCH request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @return array response data
     */
    public function patch($uri, array $data);
}

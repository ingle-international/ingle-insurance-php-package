<?php

namespace Ingle\Insurance\Api\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Ingle\Insurance\Api\Exception\AuthenticationException;
use Ingle\Insurance\Api\Exception\BadRequestException;
use Ingle\Insurance\Api\Exception\ResponseException;
use Ingle\Insurance\Api\Exception\ServerException;

class Guzzle implements BaseClient
{
    /**
     * @var BaseClient the client to use for making HTTP requests
     */
    private $client;

    /**
     * @var float the number of seconds client will wait for response
     */
    private $timeout = 15.0;

    /**
     * @var string The API key
     */
    private $apiKey;

    /**
     * @var bool
     */
    private $authorizationHeaderSet = false;

    /**
     * @var array client headers
     */
    private $headers = [
        'Content-Type'    => 'application/json',
        'Accept'          => 'application/vnd.ingle+json; version=1',
        'Accept-Language' => 'en-CA',
    ];

    /**
     * Create Guzzle client with given base URI.
     *
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        $this->client = new Client(['base_uri' => sprintf('%s/api/ingle/insurance/', $baseUri)]);
    }

    /**
     * Set the API key.
     *
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Set the authorization token using API key and creates new client containing token.
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     */
    public function setAuthorizationHeader()
    {
        if ($this->authorizationHeaderSet) {
            return;
        }

        $uri = '/token/ingle/basic';

        try {
            $responseData = json_decode(
                $this->client->post(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                        'json'    => ['token' => $this->apiKey],
                    ]
                )->getBody(), true
            );

            $this->setHeader('Authorization', sprintf('%s %s', $responseData['token_type'], $responseData['access_token']));
            $this->authorizationHeaderSet = true;
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Set a header value for client.
     *
     * @param $key
     * @param $value
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Set amount of time client will wait for response before timing out.
     *
     * @return float number of seconds
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set amount of time client will wait for response before timing out.
     *
     * @param $seconds
     */
    public function setTimeout($seconds)
    {
        $this->timeout = $seconds;
    }

    /**
     * Send a POST request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     *
     * @return array response data
     */
    public function post($uri, array $data)
    {
        $this->setAuthorizationHeader();

        try {
            return json_decode(
                $this->client->post(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                        'json'    => $data,
                    ]
                )->getBody(), true
            );
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Send a GET request to the specified URI.
     *
     * @param $uri
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     *
     * @return array response data
     */
    public function get($uri)
    {
        $this->setAuthorizationHeader();

        try {
            return json_decode(
                $this->client->get(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                    ]
                )->getBody(), true
            );
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Send a DELETE request to the specified URI.
     *
     * @param $uri
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     *
     * @return array response data
     */
    public function delete($uri)
    {
        $this->setAuthorizationHeader();

        try {
            return json_decode(
                $this->client->delete(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                    ]
                )->getBody(), true
            );
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Send a PUT request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     *
     * @return array response data
     */
    public function put($uri, array $data)
    {
        $this->setAuthorizationHeader();

        try {
            return json_decode(
                $this->client->put(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                        'json'    => $data,
                    ]
                )->getBody(), true
            );
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Send a PATCH request with the given body to the specified URI.
     *
     * @param $uri
     * @param $data
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     *
     * @return array response data
     */
    public function patch($uri, array $data)
    {
        $this->setAuthorizationHeader();

        try {
            return json_decode(
                $this->client->patch(
                    $uri,
                    [
                        'headers' => $this->headers,
                        'timeout' => $this->timeout,
                        'json'    => $data,
                    ]
                )->getBody(), true
            );
        } catch (RequestException $e) {
            $this->handleException($e, $uri);
        }
    }

    /**
     * Given a request exception, throw the appropriate exception.
     *
     * @param RequestException $e
     * @param $uri
     *
     * @throws AuthenticationException
     * @throws BadRequestException
     * @throws ResponseException
     * @throws ServerException
     */
    private function handleException(RequestException $e, $uri)
    {
        if (!$e->hasResponse()) {
            throw new ServerException($uri);
        } elseif ($e->getResponse()->getStatusCode() == 401) {
            throw new AuthenticationException();
        } elseif ($e->getResponse()->getStatusCode() == 400) {
            throw new BadRequestException($e->getResponse());
        } else {
            throw new ResponseException($e->getResponse());
        }
    }
}

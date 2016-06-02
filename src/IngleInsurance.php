<?php

namespace Ingle\Insurance\Api;

use Ingle\Insurance\Api\Client\BaseClient;
use Ingle\Insurance\Api\Client\Guzzle;

class IngleInsurance
{
    /**
     * @var BaseClient the client to use for making HTTP requests
     */
    private static $client;

    /**
     * @var string the source id
     */
    private static $source;

    /**
     * @var string the API key
     */
    private static $apiKey;

    /**
     * @var string the URL
     */
    private static $url;

    /**
     * @var float the number of seconds client will wait for response
     */
    private static $timeout;

    /**
     * Set client to be used for HTTP requests.
     *
     * @param BaseClient $client
     */
    public static function setClient(BaseClient $client)
    {
        self::$client = $client;
    }

    /**
     * Get client to be used for HTTP requests.
     *
     * @return BaseClient the client
     */
    public static function getClient()
    {
        if (!self::$client) {
            self::$client = new Guzzle(self::getUrl());
            self::$client->setApiKey(self::getApiKey());
            self::$client->setTimeout(self::getTimeout());
        }

        return self::$client;
    }

    /**
     * Set source.
     *
     * @param string $source
     */
    public static function setSource($source)
    {
        self::$source = $source;
    }

    /**
     * Get source.
     *
     * @return string the source
     */
    public static function getSource()
    {
        return self::$source;
    }

    /**
     * Set the API key.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Set the URL.
     *
     * @param string $url
     */
    public static function setUrl($url)
    {
        self::$url = $url;
    }

    /**
     * @return string
     */
    public static function getUrl()
    {
        return self::$url;
    }

    /**
     * Set amount of time client will wait for response before timing out.
     *
     * @param $seconds
     */
    public static function setTimeout($seconds)
    {
        self::$timeout = $seconds;
    }

    /**
     * Set amount of time client will wait for response before timing out.
     *
     * @return float number of seconds
     */
    public static function getTimeout()
    {
        return self::$timeout;
    }
}

<?php

namespace MaxMind\WebService\Http;

/**
 * Class RequestFactory
 * @package MaxMind\WebService\Http
 * @internal
 */
class RequestFactory
{
    public function __construct()
    {
    }

    /**
     * @param $url
     * @param $options
     * @return CurlRequest
     */
    public function request($url, $options)
    {
        return new CurlRequest($url, $options);
    }
}

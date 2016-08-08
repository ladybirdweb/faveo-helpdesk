<?php

namespace League\OAuth1\Client\Signature;

use Guzzle\Http\Url;

class HmacSha1Signature extends Signature implements SignatureInterface
{
    /**
     * {@inheritDoc}
     */
    public function method()
    {
        return 'HMAC-SHA1';
    }

    /**
     * {@inheritDoc}
     */
    public function sign($uri, array $parameters = array(), $method = 'POST')
    {
        $url = $this->createUrl($uri);

        $baseString = $this->baseString($url, $method, $parameters);

        return base64_encode($this->hash($baseString));
    }

    /**
     * Create a Guzzle url for the given URI.
     *
     * @param string $uri
     *
     * @return Url
     */
    protected function createUrl($uri)
    {
        return Url::factory($uri);
    }

    /**
     * Generate a base string for a HMAC-SHA1 signature
     * based on the given a url, method, and any parameters.
     *
     * @param Url    $url
     * @param string $method
     * @param array  $parameters
     *
     * @return string
     */
    protected function baseString(Url $url, $method = 'POST', array $parameters = array())
    {
        $baseString = rawurlencode($method).'&';

        $schemeHostPath = Url::buildUrl(array(
           'scheme' => $url->getScheme(),
           'host' => $url->getHost(),
           'path' => $url->getPath(),
        ));

        $baseString .= rawurlencode($schemeHostPath).'&';

        $data = array();
        parse_str($url->getQuery(), $query);
        foreach (array_merge($query, $parameters) as $key => $value) {
            $data[rawurlencode($key)] = rawurlencode($value);
        }

        ksort($data);
        array_walk($data, function (&$value, $key) {
            $value = $key.'='.$value;
        });
        $baseString .= rawurlencode(implode('&', $data));

        return $baseString;
    }

    /**
     * Hashes a string with the signature's key.
     *
     * @param string $string
     *
     * @return string
     */
    protected function hash($string)
    {
        return hash_hmac('sha1', $string, $this->key(), true);
    }
}

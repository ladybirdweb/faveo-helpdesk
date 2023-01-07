<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Provider\Wechat;

use GuzzleHttp\Client;
use Mremi\UrlShortener\Exception\InvalidApiResponseException;
use Mremi\UrlShortener\Provider\Bitly\AuthenticationInterface;

/**
 * OAuth client class.
 *
 * @author zacksleo <zacksleo@gmail.com>
 */
class OAuthClient implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $appid;

    /**
     * @var string
     */
    private $appsecret;

    /**
     * Constructor.
     *
     * @param string $appid     A valid Wechat appid
     * @param string $appsecret A valid Wechat appsecret
     */
    public function __construct($appid, $appsecret)
    {
        $this->appid     = $appid;
        $this->appsecret = $appsecret;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        $client = new Client([
            'base_uri' => 'https://api.weixin.qq.com',
        ]);

        $apiRawResponse = $client->get('/cgi-bin/token', [
            'query' => [
                'grant_type' => 'client_credential',
                'appid'      => $this->appid,
                'secret'     => $this->appsecret,
            ],
        ]);
        $response = json_decode($apiRawResponse->getBody()->getContents());

        if (null === $response) {
            throw new InvalidApiResponseException('Wechat response is probably mal-formed because cannot be json-decoded.');
        }
        if (property_exists($response, 'errcode')) {
            throw new InvalidApiResponseException(sprintf(
                'Wecaht returned status code "%s" with message "%s".',
                property_exists($response, 'errcode') ? $response->errcode : '',
                property_exists($response, 'errmsg') ? $response->errmsg : ''
            ));
        }

        return $response->access_token;
    }
}

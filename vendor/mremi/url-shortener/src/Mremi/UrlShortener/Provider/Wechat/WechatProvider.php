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
use Mremi\UrlShortener\Model\LinkInterface;
use Mremi\UrlShortener\Provider\Bitly\AuthenticationInterface;
use Mremi\UrlShortener\Provider\UrlShortenerProviderInterface;

/**
 * Wechat provider class.
 *
 * @author zacksleo <zacksleo@gmail.com>
 */
class WechatProvider implements UrlShortenerProviderInterface
{
    /**
     * @var AuthenticationInterface
     */
    private $auth;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor.
     *
     * @param AuthenticationInterface $auth    An authentication instance
     * @param array                   $options An array of options used to do the shorten/expand request
     */
    public function __construct(AuthenticationInterface $auth, array $options = [])
    {
        $this->auth    = $auth;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wechat';
    }

    /**
     * {@inheritdoc}
     *
     * @param LinkInterface $link A link instance
     *
     * @throws InvalidApiResponseException
     */
    public function shorten(LinkInterface $link)
    {
        $client = $this->createClient();

        $response = $client->post(sprintf('/cgi-bin/shorturl?access_token=%s',
            $this->auth->getAccessToken()
        ), array_merge(
            [
                'json' => [
                    'action'   => 'long2short',
                    'long_url' => $link->getLongUrl(),
                ],
            ],
            $this->options
        ));

        $response = $this->validate($response->getBody()->getContents());

        $link->setShortUrl($response->short_url);
    }

    /**
     * {@inheritdoc}
     *
     * @param LinkInterface $link A link instance
     * @param string        $hash A Wechat hash
     *
     * @throws InvalidApiResponseException
     */
    public function expand(LinkInterface $link, $hash = null)
    {
        throw new InvalidApiResponseException('Wechat does not support expand url yet.');
    }

    /**
     * Creates a client.
     *
     * This method is mocked in unit tests in order to not make a real request,
     * so visibility must be protected or public.
     *
     * @return Client
     */
    protected function createClient()
    {
        return new Client([
            'base_uri' => 'https://api.weixin.qq.com',
        ]);
    }

    /**
     * Validates the Wechat's response and returns it whether the status code is 200.
     *
     * @param string $apiRawResponse
     *
     * @return object
     *
     * @throws InvalidApiResponseException
     */
    private function validate($apiRawResponse)
    {
        $response = json_decode($apiRawResponse);

        if (null === $response) {
            throw new InvalidApiResponseException('Wechat response is probably mal-formed because cannot be json-decoded.');
        }

        if (!property_exists($response, 'errcode')) {
            throw new InvalidApiResponseException('Property "errcode" does not exist within Wechat response.');
        }

        if (0 !== $response->errcode) {
            throw new InvalidApiResponseException(sprintf('Wechat returned status code "%s" with message "%s"',
                $response->errcode,
                property_exists($response, 'errmsg') ? $response->errmsg : ''
            ));
        }

        return $response;
    }
}

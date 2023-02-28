<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Provider\Bitly;

/**
 * GenericAccessTokenAuthenticator class.
 *
 * @author Marcus Sá <marcusesa@gmail.com>
 */
class GenericAccessTokenAuthenticator implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $genericAccessToken;

    /**
     * Constructor.
     *
     * @param string $genericAccessToken generic access token is a immutable token provided by Bitly
     */
    public function __construct($genericAccessToken)
    {
        $this->genericAccessToken = $genericAccessToken;
    }

    /**
     * Return the Generic Access Token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->genericAccessToken;
    }
}

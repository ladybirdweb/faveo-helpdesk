<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider\Bitly;

use Mremi\UrlShortener\Provider\Bitly\AuthenticationInterface;
use Mremi\UrlShortener\Provider\Bitly\GenericAccessTokenAuthenticator;
use PHPUnit\Framework\TestCase;

/**
 * Tests GenericAccessTokenAuthenticator class.
 *
 * @author Marcus Sá <marcusesa@gmail.com>
 */
class GenericAccessTokenAuthenticatorTest extends TestCase
{
    const GENERIC_ACCESS_TOKEN = '9a2j4kal4701mk2enk15lmi2';

    /**
     * Test if GenericAccessTokenAuthenticator implements AuthenticationInterface.
     */
    public function testGenericAccessTokenShouldImplementsAuthenticationInterface()
    {
        $genericAccessTokenAuthenticator = new GenericAccessTokenAuthenticator(self::GENERIC_ACCESS_TOKEN);

        $this->assertInstanceOf(AuthenticationInterface::class, $genericAccessTokenAuthenticator);
    }

    /**
     * Test if getAccessToken method return the generic access token provided.
     */
    public function testGetAccessTokenShouldReturnGenericAccessToken()
    {
        $genericAccessTokenAuthenticator = new GenericAccessTokenAuthenticator(self::GENERIC_ACCESS_TOKEN);

        $this->assertSame(self::GENERIC_ACCESS_TOKEN, $genericAccessTokenAuthenticator->getAccessToken());
    }
}

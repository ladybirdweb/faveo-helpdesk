<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Model;

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Model\LinkManager;
use Mremi\UrlShortener\Provider\ChainProvider;
use Mremi\UrlShortener\Provider\UrlShortenerProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Link manager class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class LinkManagerTest extends TestCase
{
    /**
     * @var LinkManager
     */
    private $manager;

    /**
     * @var object
     */
    private $chainProvider;

    /**
     * Tests the findOneByProviderAndShortUrl method.
     */
    public function testFindOneByProviderAndShortUrl()
    {
        $provider = $this->createMock(UrlShortenerProviderInterface::class);

        $provider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('bitly'));

        $provider
            ->expects($this->once())
            ->method('expand');

        $this->chainProvider
            ->expects($this->once())
            ->method('getProvider')
            ->with($this->equalTo('bitly'))
            ->will($this->returnValue($provider));

        $link = $this->manager->findOneByProviderAndShortUrl('bitly', 'http://bit.ly/ZGUlzK');

        $this->assertInstanceOf(Link::class, $link);
        $this->assertSame('http://bit.ly/ZGUlzK', $link->getShortUrl());
    }

    /**
     * Tests the findOneByProviderAndLongUrl method.
     */
    public function testFindOneByProviderAndLongUrl()
    {
        $provider = $this->createMock(UrlShortenerProviderInterface::class);

        $provider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('google'));

        $provider
            ->expects($this->once())
            ->method('shorten');

        $this->chainProvider
            ->expects($this->once())
            ->method('getProvider')
            ->with($this->equalTo('google'))
            ->will($this->returnValue($provider));

        $link = $this->manager->findOneByProviderAndLongUrl('google', 'http://www.google.com/');

        $this->assertInstanceOf(Link::class, $link);
        $this->assertSame('http://www.google.com/', $link->getLongUrl());
    }

    /**
     * Initializes chainProvider & manager properties.
     */
    protected function setUp()
    {
        $this->chainProvider = $this->getMockBuilder(ChainProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new LinkManager($this->chainProvider, Link::class);
    }
}

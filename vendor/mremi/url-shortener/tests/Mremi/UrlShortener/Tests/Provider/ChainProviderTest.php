<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider;

use Mremi\UrlShortener\Provider\Baidu\BaiduProvider;
use Mremi\UrlShortener\Provider\Bitly\BitlyProvider;
use Mremi\UrlShortener\Provider\ChainProvider;
use Mremi\UrlShortener\Provider\Google\GoogleProvider;
use Mremi\UrlShortener\Provider\Sina\SinaProvider;
use Mremi\UrlShortener\Provider\Wechat\WechatProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Tests ChainProvider class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ChainProviderTest extends TestCase
{
    /**
     * Tests that an unknown provider throws an exception.
     */
    public function testUnknownProvider()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to retrieve the provider named: "foo"');

        $chainProvider = new ChainProvider();
        $chainProvider->getProvider('foo');
    }

    /**
     * Tests to add and get some providers.
     */
    public function testAddAndGetProviders()
    {
        $chainProvider = new ChainProvider();

        $bitlyProvider = $this->getMockBuilder(BitlyProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $bitlyProvider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('bitly'));

        $chainProvider->addProvider($bitlyProvider);

        $this->assertSame($bitlyProvider, $chainProvider->getProvider('bitly'));
        $this->assertArrayHasKey('bitly', $chainProvider->getProviders());
        $this->assertTrue($chainProvider->hasProvider('bitly'));
        $this->assertCount(1, $chainProvider->getProviders());

        $googleProvider = $this->getMockBuilder(GoogleProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $googleProvider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('google'));

        $chainProvider->addProvider($googleProvider);

        $this->assertSame($googleProvider, $chainProvider->getProvider('google'));
        $this->assertArrayHasKey('google', $chainProvider->getProviders());
        $this->assertTrue($chainProvider->hasProvider('google'));
        $this->assertCount(2, $chainProvider->getProviders());

        $baiduProvider = $this->getMockBuilder(BaiduProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $baiduProvider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('baidu'));

        $chainProvider->addProvider($baiduProvider);

        $this->assertSame($baiduProvider, $chainProvider->getProvider('baidu'));
        $this->assertArrayHasKey('baidu', $chainProvider->getProviders());
        $this->assertTrue($chainProvider->hasProvider('baidu'));
        $this->assertCount(3, $chainProvider->getProviders());

        $sinaProvider = $this->getMockBuilder(SinaProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sinaProvider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('sina'));

        $chainProvider->addProvider($sinaProvider);

        $this->assertSame($sinaProvider, $chainProvider->getProvider('sina'));
        $this->assertArrayHasKey('sina', $chainProvider->getProviders());
        $this->assertTrue($chainProvider->hasProvider('sina'));
        $this->assertCount(4, $chainProvider->getProviders());

        $wechatProvider = $this->getMockBuilder(WechatProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wechatProvider
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('wechat'));

        $chainProvider->addProvider($wechatProvider);

        $this->assertSame($wechatProvider, $chainProvider->getProvider('wechat'));
        $this->assertArrayHasKey('wechat', $chainProvider->getProviders());
        $this->assertTrue($chainProvider->hasProvider('google'));
        $this->assertCount(5, $chainProvider->getProviders());
    }
}

<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git\Tests;

use Gitonomy\Git\Blob;
use Gitonomy\Git\Exception\RuntimeException;
use Prophecy\Argument;

class RepositoryTest extends AbstractTest
{
    /**
     * @dataProvider provideFoobar
     */
    public function testGetBlobWithExistingWorks($repository)
    {
        $blob = $repository->getCommit(self::LONGFILE_COMMIT)->getTree()->resolvePath('README.md');

        $this->assertInstanceOf(Blob::class, $blob, 'getBlob() returns a Blob object');

        if (method_exists($this, 'assertStringContainsString')) {
            $this->assertStringContainsString('Foo Bar project', $blob->getContent(), 'file is correct');
        } else {
            $this->assertContains('Foo Bar project', $blob->getContent(), 'file is correct');
        }
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetSize($repository)
    {
        $size = $repository->getSize();
        $this->assertGreaterThanOrEqual(69, $size, 'Repository is at least 69KB');
        $this->assertLessThan(80, $size, 'Repository is less than 80KB');
    }

    public function testIsBare()
    {
        $bare = self::createFoobarRepository(true);
        $this->assertTrue($bare->isBare(), 'Lib repository is bare');

        $notBare = self::createFoobarRepository(false);
        $this->assertFalse($notBare->isBare(), 'Working copy is not bare');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetDescription($repository)
    {
        $this->assertSame("Unnamed repository; edit this file 'description' to name the repository.\n", $repository->getDescription());
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testLoggerOk($repository)
    {
        if (!interface_exists('Psr\Log\LoggerInterface')) {
            $this->markTestSkipped();
        }

        $loggerProphecy = $this->prophesize('Psr\Log\LoggerInterface');
        $loggerProphecy
            ->info('run command: remote "" ')
            ->shouldBeCalledTimes(1);
        $loggerProphecy
            ->debug(Argument::type('string')) // duration, return code and output
            ->shouldBeCalledTimes(3);

        $repository->setLogger($loggerProphecy->reveal());

        $repository->run('remote');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testLoggerNOk($repository)
    {
        if (!interface_exists('Psr\Log\LoggerInterface')) {
            $this->markTestSkipped();
        }

        $this->expectException(RuntimeException::class);

        $loggerProphecy = $this->prophesize('Psr\Log\LoggerInterface');
        $loggerProphecy
            ->info(Argument::type('string'))
            ->shouldBeCalledTimes(1);
        $loggerProphecy
            ->debug(Argument::type('string')) // duration, return code and output
            ->shouldBeCalledTimes(3);
        $loggerProphecy
            ->error(Argument::type('string'))
            ->shouldBeCalledTimes(1);

        $repository->setLogger($loggerProphecy->reveal());

        $repository->run('not-work');
    }
}

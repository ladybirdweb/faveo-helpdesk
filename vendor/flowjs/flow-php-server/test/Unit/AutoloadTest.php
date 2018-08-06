<?php

namespace Unit;


/**
 * Autoload unit tests
 *
 * @coversDefaultClass \Flow\Autoloader
 *
 * @package Unit
 */
class AutoloadTest extends FlowUnitCase
{
	/**
	 * @covers ::__construct
	 * @covers ::getDir
	 */
	public function testAutoloader_construct_default()
	{
		$expDir = realpath(__DIR__ . '/../../src/Flow') . '/..';
		$autoloader = new \Flow\Autoloader();

		$this->assertSame($expDir, $autoloader->getDir());
	}

	/**
	 * @covers ::__construct
	 * @covers ::getDir
	 */
	public function testAutoloader_construct_custom()
	{
		$expDir = __DIR__;
		$autoloader = new \Flow\Autoloader($expDir);

		$this->assertSame($expDir, $autoloader->getDir());
	}

	/**
	 * @covers ::autoload
	 */
    public function testClassesExist()
    {
        $autoloader = new \Flow\Autoloader();

	    $autoloader->autoload('noclass');
        $this->assertFalse(class_exists('noclass', false));

	    $autoloader->autoload('Flow\NoClass');
        $this->assertFalse(class_exists('Flow\NoClass', false));

	    $autoloader->autoload('Flow\File');
        $this->assertTrue(class_exists('Flow\File'));
    }
}

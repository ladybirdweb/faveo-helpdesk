<?php

/*
 * This file is part of the Fetch library.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fetch\Test;

/**
 * @package Fetch
 * @author  Robert Hafner <tedivm@tedivm.com>
 */
class AttachmentTest extends \PHPUnit_Framework_TestCase
{

    public static function getAttachments($MessageId)
    {
        $server = ServerTest::getServer();
        $message = new \Fetch\Message($MessageId, $server);
        $attachments = $message->getAttachments();
        $returnAttachments = array();
        foreach($attachments as $attachment)
            $returnAttachments[$attachment->getFileName()] = $attachment;

        return $returnAttachments;
    }

    public function testGetData()
    {
        $attachments = static::getAttachments('6');

        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $md5_RCA = '3e9b6f02551590a7bcfff5d50b5b7b20';
        $this->assertEquals($md5_RCA, md5($attachment_RCA->getData()));

        $attachment_TestCard = $attachments['Test_card.png.zip'];
        $md5_TestCard = '94c40bd83fbfa03b29bf1811f9aaccea';
        $this->assertEquals($md5_TestCard, md5($attachment_TestCard->getData()));
    }

    public function testGetMimeType()
    {
        $attachments = static::getAttachments('6');

        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $mimetype_RCA = 'application/zip';
        $this->assertEquals($mimetype_RCA, $attachment_RCA->getMimeType());

        $attachment_TestCard = $attachments['Test_card.png.zip'];
        $mimetype_TestCard = 'application/zip';
        $this->assertEquals($mimetype_TestCard, $attachment_TestCard->getMimeType());
    }

    public function testGetSize()
    {
        $attachments = static::getAttachments('6');

        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $size_RCA = 378338;
        $this->assertEquals($size_RCA, $attachment_RCA->getSize());

        $attachment_TestCard = $attachments['Test_card.png.zip'];
        $size_TestCard = 32510;
        $this->assertEquals($size_TestCard, $attachment_TestCard->getSize());
    }

    public function testGetStructure()
    {
        $attachments = static::getAttachments('6');

        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $structure_RCA = $attachment_RCA->getStructure();

        $this->assertObjectHasAttribute('type', $structure_RCA);
        $this->assertEquals(3, $structure_RCA->type);

        $this->assertObjectHasAttribute('subtype', $structure_RCA);
        $this->assertEquals('ZIP', $structure_RCA->subtype);

        $this->assertObjectHasAttribute('bytes', $structure_RCA);
        $this->assertEquals(378338, $structure_RCA->bytes);
    }

    public function testSaveToDirectory()
    {
        $attachments = static::getAttachments('6');

        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];

        $tmpdir = rtrim(sys_get_temp_dir(), '/') . '/';
        $filepath = $tmpdir . 'RCA_Indian_Head_test_pattern.JPG.zip';

        $this->assertTrue($attachment_RCA->saveToDirectory($tmpdir));

        $this->assertFileExists($filepath);
        $this->assertEquals(md5(file_get_contents($filepath)), md5($attachment_RCA->getData()));

        $attachments = static::getAttachments('6');
        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $this->assertFalse($attachment_RCA->saveToDirectory('/'), 'Returns false when attempting to save without filesystem permission.');

        $attachments = static::getAttachments('6');
        $attachment_RCA = $attachments['RCA_Indian_Head_test_pattern.JPG.zip'];
        $this->assertFalse($attachment_RCA->saveToDirectory($filepath), 'Returns false when attempting to save over a file.');
    }

    public static function tearDownAfterClass()
    {
        $tmpdir = rtrim(sys_get_temp_dir(), '/') . '/';
        $filepath = $tmpdir . 'RCA_Indian_Head_test_pattern.JPG.zip';
        unlink($filepath);
    }
}

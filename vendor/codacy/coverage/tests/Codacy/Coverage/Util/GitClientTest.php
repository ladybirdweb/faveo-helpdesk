<?php

use Codacy\Coverage\Util\GitClient;

class GitClientTest extends \PHPUnit\Framework\TestCase
{
    public function testGetHashOfLastCommit()
    {
        $gitClient = new GitClient(getcwd());
        $hash = $gitClient->getHashOfLatestCommit();
        $this->assertEquals(40, strlen($hash));
    }
}
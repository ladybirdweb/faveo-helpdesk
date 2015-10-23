<?php

function build_phar()
{
    $phar = new Phar('build/bugsnag.phar');
    $phar->buildFromDirectory(dirname(__FILE__) . '/src','/\.php$/');
    $phar->compressFiles(Phar::GZ);
    $phar->stopBuffering();
    $phar->setStub($phar->createDefaultStub('Bugsnag/Autoload.php'));
}

build_phar();

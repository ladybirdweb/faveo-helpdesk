<?php

namespace App\Http\Controllers\Admin;

use Fetch\Server;

class MailFetch extends Server
{
    public function __construct($serverPath, $port = 143, $service = 'imap')
    {
        $this->serverPath = $serverPath;

        $this->port = $port;

        $this->service = $service;
    }
}

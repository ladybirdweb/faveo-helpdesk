<?php

class PodioOAuth
{
    public $access_token;
    public $refresh_token;
    public $expires_in;
    public $ref;

    public function __construct($access_token = null, $refresh_token = null, $expires_in = null, $ref = null)
    {
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->expires_in = $expires_in;
        $this->ref = $ref;
    }
}

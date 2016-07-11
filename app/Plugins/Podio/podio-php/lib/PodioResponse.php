<?php

class PodioResponse
{
    public $body;
    public $status;
    public $headers;

    public function json_body()
    {
        return json_decode($this->body, true);
    }
}

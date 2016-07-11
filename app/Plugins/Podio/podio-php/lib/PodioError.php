<?php

class PodioError extends Exception
{
    public $body;
    public $status;
    public $url;

    public function __construct($body, $status, $url)
    {
        $this->body = json_decode($body, true);
        $this->status = $status;
        $this->url = $url;
        $this->request = $this->body['request'];
        parent::__construct(get_class($this), 1, null);
    }

    public function __toString()
    {
        $str = $str = get_class($this);
        if (!empty($this->body['error_description'])) {
            $str .= ': "'.$this->body['error_description'].'"';
        }
        $str .= "\nRequest URL: ".$this->request['url'];
        if (!empty($this->request['query_string'])) {
            $str .= '?'.$this->request['query_string'];
        }
        if (!empty($this->request['body'])) {
            $str .= "\nRequest Body: ".json_encode($this->request['body']);
        }

        $str .= "\n\nStack Trace: \n".$this->getTraceAsString();

        return $str;
    }
}
class PodioInvalidGrantError extends PodioError
{
}
class PodioBadRequestError extends PodioError
{
}
class PodioAuthorizationError extends PodioError
{
}
class PodioForbiddenError extends PodioError
{
}
class PodioNotFoundError extends PodioError
{
}
class PodioConflictError extends PodioError
{
}
class PodioGoneError extends PodioError
{
}
class PodioRateLimitError extends PodioError
{
}
class PodioServerError extends PodioError
{
}
class PodioUnavailableError extends PodioError
{
}
class PodioMissingRelationshipError extends PodioError
{
}

class PodioConnectionError extends Exception
{
}
class PodioDataIntegrityError extends Exception
{
}

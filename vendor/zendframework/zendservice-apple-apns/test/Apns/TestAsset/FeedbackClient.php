<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Service
 */

namespace ZendServiceTest\Apple\Apns\TestAsset;

use ZendService\Apple\Apns\Exception;
use ZendService\Apple\Apns\Client\Feedback as ZfFeedbackClient;

/**
 * Feedback Client Proxy
 * This class is utilized for unit testing purposes
 *
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage Apns
 */
class FeedbackClient extends ZfFeedbackClient
{
    /**
     * Read Response
     *
     * @var string
     */
    protected $readResponse;

    /**
     * Write Response
     *
     * @var mixed
     */
    protected $writeResponse;

    /**
     * Set the Response
     *
     * @param  string         $str
     * @return FeedbackClient
     */
    public function setReadResponse($str)
    {
        $this->readResponse = $str;

        return $this;
    }

    /**
     * Set the write response
     *
     * @param  mixed          $resp
     * @return FeedbackClient
     */
    public function setWriteResponse($resp)
    {
        $this->writeResponse = $resp;

        return $this;
    }

    /**
     * Connect to Host
     *
     * @return FeedbackClient
     */
    protected function connect($host, array $ssl)
    {
        return $this;
    }

    /**
     * Return Response
     *
     * @param  string $length
     * @return string
     */
    protected function read($length = 1024)
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to reading data');
        }
        $ret = substr($this->readResponse, 0, $length);
        $this->readResponse = null;

        return $ret;
    }

    /**
     * Write and Return Length
     *
     * @param  string $payload
     * @return int
     */
    protected function write($payload)
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to writing data');
        }
        $ret = $this->writeResponse;
        $this->writeResponse = null;

        return (null === $ret) ? strlen($payload) : $ret;
    }
}

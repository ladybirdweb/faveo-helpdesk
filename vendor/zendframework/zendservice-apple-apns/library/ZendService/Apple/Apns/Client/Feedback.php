<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Service
 */

namespace ZendService\Apple\Apns\Client;

use ZendService\Apple\Exception;
use ZendService\Apple\Apns\Response\Feedback as FeedbackResponse;

/**
 * Feedback Client
 */
class Feedback extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = array(
        'tls://feedback.sandbox.push.apple.com:2196',
        'tls://feedback.push.apple.com:2196'
    );

    /**
     * Get Feedback
     *
     * @return array of ZendService\Apple\Apns\Response\Feedback
     */
    public function feedback()
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $tokens = array();
        while ($token = $this->read(38)) {
            $tokens[] = new FeedbackResponse($token);
        }

        return $tokens;
    }
}

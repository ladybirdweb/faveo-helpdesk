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
use ZendService\Apple\Exception\StreamSocketClientException;

/**
 * Apple Push Notification Abstract Client
 */
abstract class AbstractClient
{
    /**
     * APNS URI Constants
     * @var int
     */
    const SANDBOX_URI = 0;
    const PRODUCTION_URI = 1;

    /**
     * APNS URIs
     * @var array
     */
    protected $uris = array();

    /**
     * Is Connected
     * @var boolean
     */
    protected $isConnected = false;

    /**
     * Stream Socket
     * @var Resource
     */
    protected $socket;

    /**
     * Open Connection to APNS Service
     *
     * @param  int                                $environment
     * @param  string                             $certificate
     * @param  string                             $passPhrase
     * @throws Exception\RuntimeException
     * @throws Exception\InvalidArgumentException
     * @return AbstractClient
     */
    public function open($environment, $certificate, $passPhrase = null)
    {
        if ($this->isConnected) {
            throw new Exception\RuntimeException('Connection has already been opened and must be closed');
        }

        if (!array_key_exists($environment, $this->uris)) {
            throw new Exception\InvalidArgumentException('Environment must be one of PRODUCTION_URI or SANDBOX_URI');
        }

        if (!is_string($certificate) || !file_exists($certificate)) {
            throw new Exception\InvalidArgumentException('Certificate must be a valid path to a APNS certificate');
        }

        $sslOptions = array(
            'local_cert' => $certificate,
        );
        if ($passPhrase !== null) {
            if (!is_scalar($passPhrase)) {
                throw new Exception\InvalidArgumentException('SSL passphrase must be a scalar');
            }
            $sslOptions['passphrase'] = $passPhrase;
        }
        $this->connect($this->uris[$environment], $sslOptions);
        $this->isConnected = true;

        return $this;
    }

    /**
     * Connect to Host
     *
     * @param  string         $host
     * @param  array          $ssl
     * @return AbstractClient
     */
    protected function connect($host, array $ssl)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new StreamSocketClientException($errstr, $errno, 1, $errfile, $errline);
        });

        try {
            $this->socket = stream_socket_client(
                $host,
                $errno,
                $errstr,
                ini_get('default_socket_timeout'),
                STREAM_CLIENT_CONNECT,
                stream_context_create(
                    array(
                        'ssl' => $ssl,
                    )
                )
            );
        } catch (StreamSocketClientException $e) {
            throw new Exception\RuntimeException(sprintf(
                'Unable to connect: %s: %d (%s)',
                $host,
                $e->getCode(),
                $e->getMessage()
            ));
        }

        restore_error_handler();

        if (!$this->socket) {
            throw new Exception\RuntimeException(sprintf(
                'Unable to connect: %s: %d (%s)',
                $host,
                $errno,
                $errstr
            ));
        }
        stream_set_blocking($this->socket, 0);
        stream_set_write_buffer($this->socket, 0);

        return $this;
    }

    /**
     * Close Connection
     *
     * @return AbstractClient
     */
    public function close()
    {
        if ($this->isConnected && is_resource($this->socket)) {
            fclose($this->socket);
        }
        $this->isConnected = false;

        return $this;
    }

    /**
     * Is Connected
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->isConnected;
    }

    /**
     * Read from the Server
     *
     * @param  int    $length
     * @return string
     */
    protected function read($length = 6)
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to reading data');
        }
        $data = false;
        $read = array($this->socket);
        $null = null;

        if (0 < @stream_select($read, $null, $null, 1, 0)) {
            $data = @fread($this->socket, (int) $length);
        }

        return $data;
    }

    /**
     * Write Payload to the Server
     *
     * @param  string $payload
     * @return int
     */
    protected function write($payload)
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to writing data');
        }

        return @fwrite($this->socket, $payload);
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->close();
    }
}

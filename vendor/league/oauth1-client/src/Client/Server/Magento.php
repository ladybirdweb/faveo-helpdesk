<?php

namespace League\OAuth1\Client\Server;

use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Credentials\TokenCredentials;

/**
 * Magento OAuth 1.0a.
 *
 * This class reflects two Magento oddities:
 *  - Magento does not offer a user info endpoint for the currently
 *    authenticated user.
 *  - Magento expects the oauth_verifier to be located in the header instead of
 *    the post body.
 *
 * Additionally, this is initialized with two additional parameters:
 *  - Boolean 'admin' to use the admin vs customer
 *  - String 'host' with the path to the magento host
 */
class Magento extends Server
{
    /**
     * Admin url.
     *
     * @var string
     */
    protected $adminUrl;

    /**
     * Base uri.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Server is admin.
     *
     * @var bool
     */
    protected $isAdmin = false;

    /**
     * oauth_verifier stored for use with.
     *
     * @var string
     */
    private $verifier;

    /**
     * {@inheritDoc}
     */
    public function __construct($clientCredentials, SignatureInterface $signature = null)
    {
        parent::__construct($clientCredentials, $signature);
        if (is_array($clientCredentials)) {
            $this->parseConfigurationArray($clientCredentials);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function urlTemporaryCredentials()
    {
        return $this->baseUri.'/oauth/initiate';
    }

    /**
     * {@inheritDoc}
     */
    public function urlAuthorization()
    {
        return $this->isAdmin
            ? $this->adminUrl
            : $this->baseUri.'/oauth/authorize';
    }

    /**
     * {@inheritDoc}
     */
    public function urlTokenCredentials()
    {
        return $this->baseUri.'/oauth/token';
    }

    /**
     * {@inheritDoc}
     */
    public function urlUserDetails()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        return new User();
    }

    /**
     * {@inheritDoc}
     */
    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenCredentials(TemporaryCredentials $temporaryCredentials, $temporaryIdentifier, $verifier)
    {
        $this->verifier = $verifier;

        return parent::getTokenCredentials($temporaryCredentials, $temporaryIdentifier, $verifier);
    }

    /**
     * {@inheritDoc}
     */
    protected function additionalProtocolParameters()
    {
        return array(
            'oauth_verifier' => $this->verifier,
        );
    }

    /**
     * Magento does not implement a user info endpoint.
     *
     * @param TokenCredentials $tokenCredentials
     * @param bool             $force
     *
     * @return array empty array
     */
    protected function fetchUserDetails(TokenCredentials $tokenCredentials, $force = true)
    {
        return array();
    }

    /**
     * Parse configuration array to set attributes.
     *
     * @param array $configuration
     * @throws \Exception
     */
    private function parseConfigurationArray(array $configuration = array())
    {
        if (!isset($configuration['host'])) {
            throw new \Exception('Missing Magento Host');
        }
        $url = parse_url($configuration['host']);
        $this->baseUri = sprintf('%s://%s', $url['scheme'], $url['host']);

        if (isset($url['port'])) {
            $this->baseUri .= ':'.$url['port'];
        }

        if (isset($url['path'])) {
            $this->baseUri .= '/'.trim($url['path'], '/');
        }
        $this->isAdmin = !empty($configuration['admin']);
        if (!empty($configuration['adminUrl'])) {
            $this->adminUrl = $configuration['adminUrl'].'/oauth_authorize';
        } else {
            $this->adminUrl = $this->baseUri.'/admin/oauth_authorize';
        }
    }
}

<?php
/**
 * @link      http://github.com/zendframework/zend-validator for the canonical source repository
 * @copyright Copyright (c) 2019 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Validator;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

final class UndisclosedPassword extends AbstractValidator
{
    private const HIBP_API_URI = 'https://api.pwnedpasswords.com';
    private const HIBP_API_REQUEST_TIMEOUT = 300;
    private const HIBP_CLIENT_USER_AGENT_STRING = 'zend-validator';
    private const HIBP_CLIENT_ACCEPT_HEADER = 'application/vnd.haveibeenpwned.v2+json';
    private const HIBP_K_ANONYMITY_HASH_RANGE_LENGTH = 5;
    private const HIBP_K_ANONYMITY_HASH_RANGE_BASE = 0;
    private const SHA1_STRING_LENGTH = 40;

    private const PASSWORD_BREACHED = 'passwordBreached';
    private const NOT_A_STRING = 'wrongInput';

    protected $messageTemplates = [
        self::PASSWORD_BREACHED =>
            'The provided password was found in previous breaches, please create another password',
        self::NOT_A_STRING => 'The provided password is not a string, please provide a correct password',
    ];

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    private $makeHttpRequest;

    /**
     * @var ResponseFactoryInterface
     */
    private $makeHttpResponse;

    /**
     * PasswordBreach constructor.
     */
    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $makeHttpRequest,
        ResponseFactoryInterface $makeHttpResponse
    ) {
        $this->httpClient = $httpClient;
        $this->makeHttpRequest = $makeHttpRequest;
        $this->makeHttpResponse = $makeHttpResponse;
    }

    /**
     * @inheritDoc
     */
    public function isValid($value)
    {
        if (! is_string($value)) {
            $this->error(self::NOT_A_STRING);
            return false;
        }

        if ($this->isPwnedPassword($value)) {
            $this->error(self::PASSWORD_BREACHED);
            return false;
        }

        return true;
    }

    private function isPwnedPassword(string $password) : bool
    {
        $sha1Hash = $this->hashPassword($password);
        $rangeHash = $this->getRangeHash($sha1Hash);
        $hashList = $this->retrieveHashList($rangeHash);
        return $this->hashInResponse($sha1Hash, $hashList);
    }

    /**
     * We use a SHA1 hashed password for checking it against
     * the breached data set of HIBP.
     *
     * @param string $password
     * @return string
     */
    private function hashPassword(string $password) : string
    {
        $hashedPassword = \sha1($password);
        return strtoupper($hashedPassword);
    }

    /**
     * Creates a hash range that will be send to HIBP API
     * applying K-Anonymity
     *
     * @param string $passwordHash
     * @return string
     * @see https://www.troyhunt.com/enhancing-pwned-passwords-privacy-by-exclusively-supporting-anonymity/
     */
    private function getRangeHash(string $passwordHash) : string
    {
        return substr($passwordHash, self::HIBP_K_ANONYMITY_HASH_RANGE_BASE, self::HIBP_K_ANONYMITY_HASH_RANGE_LENGTH);
    }

    /**
     * Making a connection to the HIBP API to retrieve a
     * list of hashes that all have the same range as we
     * provided.
     *
     * @param string $passwordRange
     * @return string
     * @throws ClientExceptionInterface
     */
    private function retrieveHashList(string $passwordRange) : string
    {
        $request = $this->makeHttpRequest->createRequest(
            'GET',
            self::HIBP_API_URI . '/range/' . $passwordRange
        );

        $response = $this->httpClient->sendRequest($request);
        return (string) $response->getBody();
    }

    /**
     * Checks if the password is in the response from HIBP
     *
     * @param string $sha1Hash
     * @param string $resultStream
     * @return bool
     */
    private function hashInResponse(string $sha1Hash, string $resultStream) : bool
    {
        $data = explode("\r\n", $resultStream);
        $hashes = array_filter($data, function ($value) use ($sha1Hash) {
            list($hash, $count) = explode(':', $value);
            if (0 === strcmp($hash, substr($sha1Hash, self::HIBP_K_ANONYMITY_HASH_RANGE_LENGTH))) {
                return true;
            }
            return false;
        });
        if ([] === $hashes) {
            return false;
        }
        return true;
    }
}

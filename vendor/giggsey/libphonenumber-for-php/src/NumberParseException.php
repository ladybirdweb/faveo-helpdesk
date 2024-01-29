<?php

namespace libphonenumber;

/**
 * Generic exception class for errors encountered when parsing phone numbers.
 * @author Lara Rennie
 */
class NumberParseException extends \Exception
{
    /**
     * The country code supplied did not belong to a supported country or non-geographical entity.
     */
    const INVALID_COUNTRY_CODE = 0;
    /**
     * This indicates the string passed is not a valid number. Either the string had less than 3
     * digits in it or had an invalid phone-context parameter. More specifically, the number failed
     * to match the regular expression VALID_PHONE_NUMBER, RFC3966_GLOBAL_NUMBER_DIGITS, or
     * RFC3966_DOMAINNAME in PhoneNumberUtil
     */
    const NOT_A_NUMBER = 1;
    /**
     * This indicates the string started with an international dialing prefix, but after this was
     * stripped from the number, had less digits than any valid phone number (including country
     * code) could have.
     */
    const TOO_SHORT_AFTER_IDD = 2;
    /**
     * This indicates the string, after any country code has been stripped, had less digits than any
     * valid phone number could have.
     */
    const TOO_SHORT_NSN = 3;
    /**
     * This indicates the string had more digits than any valid phone number could have.
     */
    const TOO_LONG = 4;

    protected $errorType;

    public function __construct($errorType, $message, $previous = null)
    {
        parent::__construct($message, $errorType, $previous);
        $this->message = $message;
        $this->errorType = $errorType;
    }

    /**
     * Returns the error type of the exception that has been thrown.
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    public function __toString()
    {
        return 'Error type: ' . $this->errorType . '. ' . $this->message;
    }
}

<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class
 *
 * @package Clivern\Imap\Core\Exception
 */
class AuthenticationFailedException extends \Exception
{

    /**
     * Class Constructor
     *
     * @param string $error
     */
    public function __construct($error = null)
    {
        parent::__construct(sprintf("Authentication failed with error: %s", $error));
    }
}
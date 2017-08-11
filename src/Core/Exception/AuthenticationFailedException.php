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

    public function __construct($error = null)
    {
        parent::__construct(
            sprintf(
                "Authentication failed with error: %s",
                $server,
                $port,
                $email,
                $error
            )
        );
    }
}
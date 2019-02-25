<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class.
 */
class AuthenticationFailedException extends \Exception
{
    /**
     * Class Constructor.
     *
     * @param string $error
     */
    public function __construct($error = null)
    {
        parent::__construct(sprintf('Authentication failed with error: %s', $error));
    }
}

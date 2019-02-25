<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class.
 */
class MessageDoesNotExistException extends \Exception
{
    /**
     * Class Constructor.
     *
     * @param int    $number
     * @param string $error
     */
    public function __construct($number, $error)
    {
        parent::__construct(sprintf('Message %s does not exist: %s', $number, $error));
    }
}

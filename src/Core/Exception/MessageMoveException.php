<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class.
 */
class MessageMoveException extends \Exception
{
    /**
     * Class Constructor.
     *
     * @param int    $message_number
     * @param string $mailbox
     */
    public function __construct($message_number, $mailbox)
    {
        parent::__construct(sprintf('Message %s cannot be moved to %s', $message_number, $mailbox));
    }
}

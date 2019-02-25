<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class.
 */
class MessageDeleteException extends \Exception
{
    /**
     * Class Constructor.
     *
     * @param int $message_number
     */
    public function __construct($message_number)
    {
        parent::__construct(sprintf('Message %s cannot be deleted', $message_number));
    }
}

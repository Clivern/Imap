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
class MessageMoveException extends \Exception
{

    /**
     * Class Constructor
     *
     * @param integer $message_number
     * @param string $mailbox
     */
    public function __construct($message_number, $mailbox)
    {
        parent::__construct(sprintf('Message %s cannot be moved to %s', $message_number, $mailbox));
    }
}
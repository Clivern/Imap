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
class MessageDeleteException extends \Exception
{

    /**
     * Class Constructor
     *
     * @param integer $message_number
     */
    public function __construct($message_number)
    {
        parent::__construct(sprintf('Message %s cannot be deleted', $message_number));
    }
}
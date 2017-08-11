<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Message;
use Clivern\Imap\Core\Connection;

/**
 * Message Iterator Class
 *
 * @package Clivern\Imap\Core
 */
class MessageIterator extends \ArrayIterator
{

    protected $connection;

    /**
     * Constructor
     *
     * @param Connection $connection
     * @param array $message_numbers
     */
    public function __construct(Connection $connection, array $message_numbers)
    {
        $this->connection = $connection;
        parent::__construct($message_numbers);
    }

    /**
     * Get current message
     *
     * @return Message
     */
    public function current()
    {
        $message = new Message($this->connection);
        return $message->setUid(parent::current())->config();
    }
}
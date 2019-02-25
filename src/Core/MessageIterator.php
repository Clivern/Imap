<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Message\Action;
use Clivern\Imap\Core\Message\Body;
use Clivern\Imap\Core\Message\Header;

/**
 * Message Iterator Class.
 */
class MessageIterator extends \ArrayIterator
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Constructor.
     *
     * @param Connection $connection
     * @param array      $message_numbers
     */
    public function __construct(Connection $connection, array $message_numbers)
    {
        $this->connection = $connection;
        parent::__construct($message_numbers);
    }

    /**
     * Get current message.
     *
     * @return Message
     */
    public function current()
    {
        $message = new Message(
            $this->connection,
            new Header($this->connection),
            new Action($this->connection),
            new Body($this->connection)
        );

        return $message->setUid(parent::current())->config();
    }
}

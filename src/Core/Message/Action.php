<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Action Class.
 */
class Action
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var int
     */
    protected $message_number;

    /**
     * @var int
     */
    protected $message_uid;

    /**
     * Class Constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Config Message.
     *
     * @param int $message_number
     * @param int $message_uid
     *
     * @return Action
     */
    public function config($message_number, $message_uid)
    {
        $this->message_number = $message_number;
        $this->message_uid = $message_uid;

        return $this;
    }

    /**
     * Delete Message.
     *
     * @return bool
     */
    public function delete()
    {
        return (bool) imap_delete($this->connection->getStream(), $this->message_uid, \FT_UID);
    }

    /**
     * Undelete Message.
     *
     * @return bool
     */
    public function undelete()
    {
        return (bool) imap_undelete($this->connection->getStream(), $this->message_uid, \FT_UID);
    }
}

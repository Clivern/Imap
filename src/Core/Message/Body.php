<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Body Class.
 */
class Body
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
     * @var int
     */
    protected $encoding;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * Class Constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Config Body.
     *
     * @param int $message_number
     * @param int $message_uid
     *
     * @return Body
     */
    public function config($message_number, $message_uid)
    {
        $this->message_number = $message_number;
        $this->message_uid = $message_uid;

        return $this;
    }

    /**
     * Get Message.
     *
     * @param int $option
     *
     * @return string
     */
    public function getMessage($option = 2)
    {
        if (!empty($this->message)) {
            return $this->message;
        }

        $structure = imap_fetchstructure($this->connection->getStream(), $this->message_number);

        if (isset($structure->parts) && \is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];
            $this->message = imap_fetchbody($this->connection->getStream(), $this->message_number, $option);

            $this->encoding = $part->encoding;

            if (3 === $part->encoding) {
                $this->message = imap_base64($this->message);
            } elseif (1 === $part->encoding) {
                $this->message = imap_8bit($this->message);
            } else {
                $this->message = imap_qprint($this->message);
            }
        } else {
            $this->message = imap_body($this->connection->getStream(), $this->message_number, $option);
        }

        return $this->message;
    }

    /**
     * Get Encoding.
     *
     * @return int
     */
    public function getEncoding()
    {
        return $this->encoding;
    }
}

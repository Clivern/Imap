<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap;

use Clivern\Imap\Core\Connection;
use Clivern\Imap\Core\MessageIterator;
use Clivern\Imap\Core\Message;
use Clivern\Imap\Core\Search;
use Clivern\Imap\Core\Message\Header;
use Clivern\Imap\Core\Message\Actions;

/**
 * MailBox Class
 *
 * @package Clivern\Imap
 */
class MailBox
{

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Constructor
     *
     * @param Connection $connection IMAP connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set Folder Name
     *
     * @param string $folder
     * @return MailBox
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * Get Folder name
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Get number of messages in this mailbox
     *
     * @return int
     */
    public function count()
    {
        $this->connection->survive($this->folder);
        return imap_num_msg($this->connection->getStream());
    }

    /**
     * Get message ids
     *
     * @param Search $search
     * @return MessageIterator
     */
    public function getMessages(Search $search = null)
    {
        $this->connection->survive($this->folder);
        $query = ($search) ? (string) $search : 'ALL';
        $message_numbers = imap_search($this->connection->getStream(), $query, \SE_UID);

        if (false == $message_numbers) {
            // imap_search can also return false
            $message_numbers = [];
        }

        return new MessageIterator($this->connection, $message_numbers);
    }

    /**
     * Get a message by message number or uid
     *
     * @param int|boolean $message_number
     * @param int|boolean $message_uid
     * @return Message
     */
    public function getMessage($message_number = false, $message_uid = false)
    {
        $this->connection->survive($this->folder);

        $message = new Message($this->connection, new Header($this->connection), new Actions($this->connection));

        if( $message_number == false ){
            return $message->setUid($message_uid)->config();
        }else{
            return $message->setMsgNo($message_number)->config();
        }
    }

    /**
     * Delete all messages marked for deletion
     *
     * @return Mailbox
     */
    public function expunge()
    {
        $this->connection->survive($this->folder);
        imap_expunge($this->connection->getStream());
    }
}
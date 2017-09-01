<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Connection;
use Clivern\Imap\Core\Message\Header;
use Clivern\Imap\Core\Message\Action;
use Clivern\Imap\Core\Message\Attachment;
use Clivern\Imap\Core\Message\Body;

/**
 * Message Class
 *
 * @package Clivern\Imap\Core
 */
class Message
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Header
     */
    protected $header;

    /**
     * @var Action
     */
    protected $action;

    /**
     * @var array
     */
    protected $attachments = null;

    /**
     * @var Body
     */
    protected $body;

    /**
     * @var integer
     */
    protected $uid;

    /**
     * @var integer
     */
    protected $msg_number;

    /**
     * Message Constructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection, Header $header, Action $action, Body $body)
    {
        $this->connection = $connection;
        $this->header = $header;
        $this->action = $action;
        $this->body = $body;
    }

    /**
     * Set Message Number
     *
     * @param integer $id
     * @return Message
     */
    public function setMsgNo($msg_number)
    {
        $this->msg_number = $msg_number;

        return $this;
    }

    /**
     * Get Message Number
     *
     * @return integer
     */
    public function getMsgNo()
    {
        return $this->msg_number;
    }

    /**
     * Set UID
     *
     * @param integer $uid
     * @return Message
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get UID
     *
     * @return integer
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Config Message Number & UID
     *
     * @return Message
     */
    public function config()
    {
        if( !$this->msg_number && $this->uid ){
            $this->msg_number = imap_msgno($this->connection->getStream(), $this->uid);
        }

        if( !$this->uid && $this->msg_number ){
            $this->uid = imap_uid($this->connection->getStream(), $this->msg_number);
        }

        return $this;
    }

    /**
     * Get Message Header Object
     *
     * @return Header
     */
    public function header()
    {
        return $this->header->config($this->msg_number, $this->uid, $options = 0);
    }

    /**
     * Get Message Action Object
     *
     * @return Action
     */
    public function action()
    {
        return $this->action->config($this->msg_number, $this->uid);
    }

    /**
     * Get Message Body Object
     *
     * @return Body
     */
    public function body()
    {
        return $this->body->config($this->msg_number, $this->uid);
    }

    /**
     * Get Message Attachments
     *
     * @return array
     */
    public function attachments()
    {
        if( !is_null($this->attachments) ){
            return $this->attachments;
        }

        $structure = imap_fetchstructure($this->connection->getStream(), $this->getMsgNo());

        $this->attachments = [];
        if (!isset($structure->parts)) {
            return $this->attachments;
        }

        $i = 0;
        foreach ($structure->parts as $index => $part) {
            if (!$part->ifdisposition){
                continue;
            }
            $this->attachments[$i] = new Attachment($this->connection);
            $this->attachments[$i]->config($this->getMsgNo(), $this->getUid(), $index + 1, $part);
            $i += 1;
        }

        return $this->attachments;
    }

    /**
     * Get Body
     *
     * @param integer $options
     * @return string
     */
    public function getBody($options = 0)
    {
        $body = imap_body($this->connection->getStream(), $this->msg_number, $options);

        return $body;
    }

    /**
     * Delete message
     *
     * @return boolean
     */
    public function delete()
    {
        return imap_delete($this->connection->getStream(), $this->msg_number);
    }
}

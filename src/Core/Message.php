<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Connection;
use Clivern\Imap\Core\Message\Header;
use Clivern\Imap\Core\Message\Actions;

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
     * @var Actions
     */
    protected $actions;

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
    public function __construct(Connection $connection, Header $header, Actions $actions)
    {
        $this->connection = $connection;
        $this->header = $header;
        $this->actions = $actions;
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
     * Get Message Actions Object
     *
     * @return Actions
     */
    public function actions()
    {
        return $this->actions->config($this->msg_number, $this->uid, $options = 0);
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
     * Parse Address List
     *
     * @param string $address_string
     * @return array
     */
    public function parseAddressList($address_string, $default_host = "example.com")
    {
        $address_array  = imap_rfc822_parse_adrlist($address_string, $default_host);
        $address_list = [];

        foreach ($address_array as $id => $val) {
            $address_list[] = [
                'mailbox' => $val->mailbox,
                'host' => $val->host,
                'personal' => $val->personal,
                'adl' => $val->adl
            ];
        }

        return $address_list;
    }

    /**
     * Fetch Body
     *
     * @param  mixed $section
     * @param  mixed $options
     * @return string
     */
    public function fetchBody($section = 0, $options = 0)
    {
        return imap_fetchbody($this->connection->getStream(), $this->msg_number, $section, $options);
    }

    /**
     * Fetch Overview
     *
     * @param  boolean $sequence
     * @param  mixed $options
     * @return array
     */
    public function fetchOverview($sequence = false, $options = 0)
    {
        if( $sequence == false ){
            $overview = imap_fetch_overview($this->connection->getStream(), $this->msg_number, $options);
        }else{
            $overview = imap_fetch_overview($this->connection->getStream(), $sequence, $options);
        }

        $items_overview = [];

        foreach ($overview as $key => $item_overview) {
            $items_overview[] = [
                'subject' => (isset($item_overview->subject)) ? $item_overview->subject : false,
                'from' => (isset($item_overview->from)) ? $item_overview->from : false,
                'to' => (isset($item_overview->to)) ? $item_overview->to : false,
                'date' => (isset($item_overview->date)) ? $item_overview->date : false,
                'message_id' => (isset($item_overview->message_id)) ? $item_overview->message_id : false,
                'size' => (isset($item_overview->size)) ? $item_overview->size : false,
                'uid' => (isset($item_overview->uid)) ? $item_overview->uid : false,
                'msgno' => (isset($item_overview->msgno)) ? $item_overview->msgno : false,
                'recent' => (isset($item_overview->recent)) ? $item_overview->recent : false,
                'flagged' => (isset($item_overview->flagged)) ? $item_overview->flagged : false,
                'answered' => (isset($item_overview->answered)) ? $item_overview->answered : false,
                'deleted' => (isset($item_overview->deleted)) ? $item_overview->deleted : false,
                'seen' => (isset($item_overview->seen)) ? $item_overview->seen : false,
                'draft' => (isset($item_overview->draft)) ? $item_overview->draft : false,
                'udate' => (isset($item_overview->udate)) ? $item_overview->udate : false
            ];
        }

        return $items_overview;
    }

    /**
     * Fetch Header
     *
     * @param  mixed $options
     * @return string
     */
    public function fetchHeader($options = 0)
    {
        return imap_fetchheader($this->connection->getStream(), $this->msg_number, $options);
    }

    /**
     * Fetch Structure
     *
     * @param  mixed $options
     * @return stdClass
     */
    public function fetchStructure($options = 0)
    {
        $structure = imap_fetchstructure($this->connection->getStream(), $this->msg_number, $options);

        return $structure;
    }
}
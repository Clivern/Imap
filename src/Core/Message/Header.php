<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Header Class.
 */
class Header
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
     * @var array
     */
    protected $header = [];

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
     * @param int   $message_number
     * @param int   $message_uid
     * @param mixed $options
     *
     * @return Header
     */
    public function config($message_number, $message_uid, $options = 0)
    {
        if (!empty($this->header)) {
            return $this;
        }

        $this->message_number = $message_number;
        $this->message_uid = $message_uid;
        $this->load($options);

        return $this;
    }

    /**
     * Get From Header.
     *
     * @param string $key
     * @param bool   $default
     *
     * @return mixed
     */
    public function get($key, $default = false)
    {
        return (isset($this->header[mb_strtolower($key)])) ? $this->header[mb_strtolower($key)] : $default;
    }

    /**
     * Check if header has key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->header[mb_strtolower($key)]);
    }

    /**
     * Parse Address List.
     *
     * @param string $address_string
     * @param mixed  $default_host
     *
     * @return array
     */
    public function parseAddressList($address_string, $default_host = 'example.com')
    {
        $address_array = imap_rfc822_parse_adrlist($address_string, $default_host);
        $address_list = [];

        foreach ($address_array as $id => $val) {
            $address_list[] = [
                'mailbox' => $val->mailbox,
                'host' => $val->host,
                'personal' => $val->personal,
                'adl' => $val->adl,
            ];
        }

        return $address_list;
    }

    /**
     * Load Header Data.
     *
     * @param mixed $options
     *
     * @return Header
     */
    protected function load($options = 0)
    {
        $overview = imap_fetch_overview($this->connection->getStream(), $this->message_number, $options);

        foreach ($overview as $key => $item_overview) {
            $this->header['subject'] = (isset($item_overview->subject)) ? imap_utf8($item_overview->subject) : false;
            $this->header['from'] = (isset($item_overview->from)) ? $item_overview->from : false;
            $this->header['to'] = (isset($item_overview->to)) ? $item_overview->to : false;
            $this->header['date'] = (isset($item_overview->date)) ? $item_overview->date : false;
            $this->header['message_id'] = (isset($item_overview->message_id)) ? $item_overview->message_id : false;
            $this->header['in_reply_to'] = (isset($item_overview->in_reply_to)) ? $item_overview->in_reply_to : false;
            $this->header['references'] = (isset($item_overview->references)) ?
                explode(' ', $item_overview->references) : false;
            $this->header['size'] = (isset($item_overview->size)) ? $item_overview->size : false;
            $this->header['uid'] = (isset($item_overview->uid)) ? $item_overview->uid : false;
            $this->header['msgno'] = (isset($item_overview->msgno)) ? $item_overview->msgno : false;
            $this->header['recent'] = (isset($item_overview->recent)) ? $item_overview->recent : false;
            $this->header['flagged'] = (isset($item_overview->flagged)) ? $item_overview->flagged : false;
            $this->header['answered'] = (isset($item_overview->answered)) ? $item_overview->answered : false;
            $this->header['deleted'] = (isset($item_overview->deleted)) ? $item_overview->deleted : false;
            $this->header['seen'] = (isset($item_overview->seen)) ? $item_overview->seen : false;
            $this->header['draft'] = (isset($item_overview->draft)) ? $item_overview->draft : false;
            $this->header['udate'] = (isset($item_overview->udate)) ? $item_overview->udate : false;
        }

        return $this;
    }
}

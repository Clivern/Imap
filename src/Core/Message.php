<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Connection;

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
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
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
		if( !this->msg_number && $this->uid ){
			$this->msg_number = imap_msgno($this->connection->getStream(), $this->uid);
		}

		if( !this->uid && $this->msg_number ){
			$this->uid = imap_uid($this->connection->getStream(), $this->msg_number);
		}

		return $this;
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


// imap_fetchbody
// imap_fetchheader
// imap_fetchstructure
// imap_fetch_overview

}
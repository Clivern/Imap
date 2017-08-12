<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Header Class
 *
 * @package Clivern\Imap\Core\Message
 */
class Header
{

	/**
	 * @var Connection
	 */
	protected $connection;

	/**
	 * @var integer
	 */
	protected $message_number;

	/**
	 * @var array
	 */
	protected $header = [];

	/**
	 * @var integer
	 */
	protected $message_uid;

	public function __construct(Connection $connection, $message_number, $message_uid)
	{
		$this->connection = $connection;
		$this->message_number = $message_number;
		$this->message_uid = $message_uid;
	}

	/**
	 * Get From Header
	 *
	 * @param  string  $key
	 * @param  boolean $default
	 * @return mixed
	 */
	public function get($key, $default = false)
	{
		return (isset($this->header[strtolower($key)])) ? $this->header[strtolower($key)] : $default;
	}

	/**
	 * Check if header has key
	 *
	 * @param  string  $key
	 * @return boolean
	 */
	public function has($key)
	{
		return (isset($this->header[strtolower($key)]));
	}

	/**
	 * Load Header Data
	 *
	 * @return boolean
	 */
	protected function load()
	{
		#~
	}
}
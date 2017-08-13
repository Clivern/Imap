<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Actions Class
 *
 * @package Clivern\Imap\Core\Message
 */
class Actions
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
	 * @var integer
	 */
	protected $message_uid;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Config Message
	 *
	 * @param integer $message_number
	 * @param integer $message_uid
	 * @return Actions
	 */
	public function config($message_number, $message_uid)
	{
		$this->message_number = $message_number;
		$this->message_uid = $message_uid;
		return $this;
	}
}
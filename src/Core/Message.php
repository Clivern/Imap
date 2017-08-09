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
	protected $id;

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
	 * Set Message ID
	 *
	 * @param integer $id
	 * @return void
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Get Message ID
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
}
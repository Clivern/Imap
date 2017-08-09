<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap;

use Clivern\Imap\Core\Connection;
use Clivern\Imap\Core\Search;
use Clivern\Imap\Core\MessageIterator;
use Clivern\Imap\Core\Tools;

/**
 * MailBox Class
 *
 * @package Clivern\Imap
 */
class MailBox
{

	/**
	 * @var Connection
	 */
	protected $connection;

	/**
	 * @var Search
	 */
	protected $search;

	/**
	 * @var MessageIterator
	 */
	protected $message_iterator;

	/**
	 * @var Tools
	 */
	protected $tools;

	/**
	 * MailBox Constructor
	 *
	 * @param Connection      $connection
	 * @param Search          $search
	 * @param MessageIterator $message_iterator
	 * @param Tools           $tools
	 */
	public function __construct(Connection $connection, Search $search, MessageIterator $message_iterator, Tools $tools)
	{
		$this->connection = $connection;
		$this->search = $search;
		$this->message_iterator = $message_iterator;
		$this->tools = $tools
	}

	/**
	 * Get Message Iterator
	 *
	 * @return MessageIterator
	 */
	public function getMessageIterator()
	{
		return $this->message_iterator;
	}



	public function get()
	{
		return "test";
	}
}
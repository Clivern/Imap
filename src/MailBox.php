<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap;

use Clivern\Imap\Core\Connection;
use Clivern\Imap\Core\Search;
use Clivern\Imap\Core\MessageIterator;

/**
 * MailBox Class
 *
 * @package Clivern\Imap
 */
class MailBox
{

	protected $connection;
	protected $search;
	protected $message_iterator;

	public function __construct(Connection $connection, Search $search, MessageIterator $message_iterator)
	{
		$this->connection = $connection;
		$this->search = $search;
		$this->message_iterator = $message_iterator;
	}


	public function getMessageIterator()
	{
		return $this->message_iterator;
	}



	public function get()
	{
		return "test";
	}
}
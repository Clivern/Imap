<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;
use Clivern\Imap\Core\Connection;

/**
 * Stats Class
 *
 * @package Clivern\Imap\Core
 */
class Stats
{
	protected $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function getQuota($folder = 'INBOX')
	{
		return imap_get_quotaroot($this->connection->getStream(), $folder);
	}


	public function getStatus($folder = 'INBOX', $flag = SA_ALL)
	{
		return imap_status($this->connection->getStream(), "{" . $this->connection->getServer() . "}" . $folder, $flag);
	}
}
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
		$data = imap_get_quotaroot($this->connection->getStream(), $folder);

		return $data;
	}


	public function getStatus($folder = 'INBOX', $flag = SA_ALL)
	{
		$data = imap_status($this->connection->getStream(), "{" . $this->connection->getServer() . "}" . $folder, $flag);

		return $data;
	}
}
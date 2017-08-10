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
	/**
	 * @var Connection
	 */
	protected $connection;

	/**
	 * Stats Class Constructor
	 *
	 * @param Connection $connection
	 * @return void
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Get Quota
	 *
	 * @param  string $folder
	 * @return array
	 */
	public function getQuota($folder = 'INBOX')
	{
		$data = imap_get_quotaroot($this->connection->getStream(), $folder);

		return [
			'usage' => (isset($data['usage'])) ? $data['usage'] : false,
			'limit' => (isset($data['limit'])) ? $data['limit'] : false
		];
	}

	/**
	 * Get Status
	 *
	 * @param  string $folder
	 * @param  string $flag
	 * @return array
	 */
	public function getStatus($folder = 'INBOX', $flag = SA_ALL)
	{
		$data = imap_status($this->connection->getStream(), "{" . $this->connection->getServer() . "}" . $folder, $flag);

		return [
			'flags' => (isset($data->flags)) ? $data->flags : false,
			'messages' => (isset($data->messages)) ? $data->messages : false,
			'recent' => (isset($data->recent)) ? $data->recent : false,
			'unseen' => (isset($data->unseen)) ? $data->unseen : false,
			'uidnext' => (isset($data->uidnext)) ? $data->uidnext : false,
			'uidvalidity' => (isset($data->uidvalidity)) ? $data->uidvalidity : false
		];
	}
}
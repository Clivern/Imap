<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

/**
 * Connection Class
 *
 * @package Clivern\Imap\Core
 */
class Connection
{
	protected $server;
	protected $port;
	protected $email;
	protected $password;
	protected $stream;

	public function __construct($server, $port, $email, $password)
	{
		$this->server = $server;
		$this->port = $port;
		$this->email = $email;
		$this->password = $password;
	}

	public function connect()
	{

		return $this;
	}

	public function getStream()
	{
		return $this->stream;
	}
}
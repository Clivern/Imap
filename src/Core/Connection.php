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
	protected $flag;
	protected $folder;
	protected $stream;

	public function __construct($server, $port, $email, $password, $flag = "/novalidate-cert", $folder = "INBOX")
	{
		$this->server = $server;
		$this->port = $port;
		$this->email = $email;
		$this->password = $password;
	}

	public function connect()
	{
		$this->stream = imap_open("{{$this->server}:{$this->port}{$this->flag}}{$this->folder}", $this->email, $this->password);

		return $this;
	}

	public function getStream()
	{
		return $this->stream;
	}

	public function checkConnection()
	{
		return (!is_null($this->stream) && imap_ping($this->stream));
	}

	public function disconnect($flag = 0)
	{
		if( !is_null($this->stream) && !imap_ping($this->stream) ){
			if( imap_close($this->stream, $flag) ){
				$this->stream = null;
				return true;
			}else{
				return false;
			}
		}

		return false;
	}
}
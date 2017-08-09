<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Message;

/**
 * Message Iterator Class
 *
 * @package Clivern\Imap\Core
 */
class MessageIterator
{

	/**
	 * @var array
	 */
	protected $messages = [];

	/**
	 * Add Message
	 *
	 * @param Message $message
	 * @return void
	 */
	public function add(Message $message)
	{
		$this->messages[$message->getId()] = $message;
	}

	/**
	 * Check if Message Exists
	 *
	 * @param  integer $message_id
	 * @return boolean
	 */
	public function has($message_id)
	{
		return (boolean) isset($this->messages[$message_id]);
	}

	/**
	 * Get Message
	 *
	 * @param integer $message_id
	 * @return Message
	 */
	public function get($message_id)
	{
		return $this->messages[$message_id];
	}

	/**
	 * Remove Message
	 *
	 * @param integer $message_id
	 * @return boolean
	 */
	public function remove($message_id)
	{
		return (boolean) unset($this->messages[$message_id]);
	}
}
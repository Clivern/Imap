<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Search\Condition;

use Clivern\Imap\Core\Search\Contract\Condition;

/**
 * Body Class
 *
 * @package Clivern\Imap\Core\Search\Condition
 */
class Body implements Condition
{

	/**
	 * @var string
	 */
	protected $data;

	/**
	 * Class Constructor
	 *
	 * @param string $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Query String
	 *
	 * @return string
	 */
	public function __toString()
	{
		return "BODY \"{$this->data}\"";
	}
}
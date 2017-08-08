<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

/**
 * Search Class
 *
 * @package Clivern\Imap\Core
 */
class Search
{
	protected $stream;
	protected $filters;

	public function __construct($stream)
	{
		$this->stream = $stream;
	}

	public function addFilter($filter)
	{
		$this->filters[] = $filter;

		return $this;
	}

	public function getFilters()
	{
		return $this->filters;
	}
}
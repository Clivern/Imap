<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * MailBox Class Test
 *
 * @package Tests
 */
class MailBoxTest extends TestCase
{
	public function testGet()
	{
		$mb = new \Clivern\Imap\MailBox();
		$this->assertEquals($mb->get(), 'test');
	}
}
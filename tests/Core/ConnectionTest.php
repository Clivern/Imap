<?php
namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testConnect()
    {
        #$email = getenv("TEST_EMAIL");
        #$password = getenv("TEST_EMAIL_PASS");
        #$connection = new \Clivern\Imap\Core\Connection("imap.gmail.com", "993", $email, $password, "/ssl", "INBOX");
        #$this->assertTrue($connection->connect()->checkConnection());
        #$this->assertTrue($connection->connect()->disconnect());
    }
}
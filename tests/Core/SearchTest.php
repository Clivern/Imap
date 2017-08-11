<?php
namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function testConditionBuilder()
    {
        $search = new \Clivern\Imap\Core\Search();
        $search->addCondition('RECENT')->addCondition('BCC "string"')->addCondition('NEW');
        $this->assertEquals($search->getConditions(), [
            'RECENT',
            'BCC "string"',
            'NEW'
        ]);
        $this->assertEquals((string) $search, 'RECENT BCC "string" NEW');
    }
}
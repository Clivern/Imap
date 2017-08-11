<?php
namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function testConditionBuilder()
    {
        $search = new \Clivern\Imap\Core\Search();
        $search->addCondition(new \Clivern\Imap\Core\Search\Condition\To("hello@clivern.com"))
               ->addCondition(new \Clivern\Imap\Core\Search\Condition\BCC("hello@clivern.com"))
               ->addCondition(new \Clivern\Imap\Core\Search\Condition\NewFlag());
        $this->assertEquals($search->getConditions(), [
            'TO "hello@clivern.com"',
            'BCC "hello@clivern.com"',
            'NEW'
        ]);
        $this->assertEquals((string) $search, 'TO "hello@clivern.com" BCC "hello@clivern.com" NEW');
    }
}
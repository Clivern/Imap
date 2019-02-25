<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function testConditionBuilder()
    {
        $search = new \Clivern\Imap\Core\Search();
        $search->addCondition(new \Clivern\Imap\Core\Search\Condition\All())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Answered())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\BCC('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Before('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Body('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\CC('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Deleted())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Flagged())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\From('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Keyword('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\NewFlag())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Old())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\On('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Recent())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Seen())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Since('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Subject('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\Text('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\To('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\UnAnswered())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\UnDeleted())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\UnFlagged())
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\UnKeyword('val'))
            ->addCondition(new \Clivern\Imap\Core\Search\Condition\UnSeen());

        $this->assertSame($search->getConditions(), [
            'ALL',
            'ANSWERED',
            'BCC "val"',
            'BEFORE "val"',
            'BODY "val"',
            'CC "val"',
            'DELETED',
            'FLAGGED',
            'FROM "val"',
            'KEYWORD "val"',
            'NEW',
            'OLD',
            'ON "val"',
            'RECENT',
            'SEEN',
            'SINCE "val"',
            'SUBJECT "val"',
            'TEXT "val"',
            'TO "val"',
            'UNANSWERED',
            'UNDELETED',
            'UNFLAGGED',
            'UNKEYWORD "val"',
            'UNSEEN',
        ]);
        $this->assertSame(
            (string) $search,
            'ALL ANSWERED BCC "val" BEFORE "val" BODY "val" CC "val" DELETED FLAGGED FROM "val" KEYWORD "val" '.
            'NEW OLD ON "val" RECENT SEEN SINCE "val" SUBJECT "val" TEXT "val" TO "val" UNANSWERED UNDELETED '.
            'UNFLAGGED UNKEYWORD "val" UNSEEN'
        );
    }
}

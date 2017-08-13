<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Search\Condition;

use Clivern\Imap\Core\Search\Contract\Condition;

/**
 * UnAnswered Class
 *
 * @package Clivern\Imap\Core\Search\Condition
 */
class UnAnswered implements Condition
{
    /**
     * Query String
     *
     * @return string
     */
    public function __toString()
    {
        return "UNANSWERED";
    }
}
<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Search\Condition;

use Clivern\Imap\Core\Search\Contract\Condition;

/**
 * All Class.
 */
class All implements Condition
{
    /**
     * Query String.
     *
     * @return string
     */
    public function __toString()
    {
        return 'ALL';
    }
}

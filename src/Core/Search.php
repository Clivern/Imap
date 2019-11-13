<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Search\Contract\Condition;

/**
 * Search Class.
 */
class Search
{
    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * Get Conditions Query.
     *
     * @return string
     */
    public function __toString()
    {
        return (!empty($this->conditions)) ? implode(' ', $this->conditions) : '';
    }

    /**
     * Add Condition.
     *
     * @return Search
     */
    public function addCondition(Condition $condition)
    {
        $this->conditions[] = (string) $condition;

        return $this;
    }

    /**
     * Get Conditions.
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }
}

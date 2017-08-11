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

    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * Add Condition
     *
     * @param string $condition
     * @return Search
     */
    public function addCondition($condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    /**
     * Get Conditions
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Get Conditions Query
     *
     * @return string
     */
    public function __toString()
    {
        return (!empty($this->conditions)) ? implode(" ", $this->conditions) : "";
    }
}
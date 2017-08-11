<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Connection Error Class
 *
 * @package Clivern\Imap\Core\Exception
 */
class MessageDoesNotExistException extends \Exception
{
    /**
     * Class Constructor
     *
     * @param integer $number
     * @param string $error
     */
    public function __construct($number, $error)
    {
        parent::__construct(sprintf('Message %s does not exist: %s', $number, $error));
    }
}
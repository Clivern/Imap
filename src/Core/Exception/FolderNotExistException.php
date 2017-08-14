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
class FolderNotExistException extends \Exception
{

    /**
     * Class Constructor
     *
     * @param string $folder
     */
    public function __construct($folder = null)
    {
        parent::__construct(sprintf("Mailbox folder not exist: %s", $folder));
    }
}
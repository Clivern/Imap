<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Exception;

/**
 * Folder Not Exist Error Class.
 */
class FolderNotExistException extends \Exception
{
    /**
     * Class Constructor.
     *
     * @param string $folder
     */
    public function __construct($folder = null)
    {
        parent::__construct(sprintf('Mailbox folder not exist: %s', $folder));
    }
}

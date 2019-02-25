<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Attachment Class.
 */
class Attachment
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var int
     */
    protected $message_number;

    /**
     * @var int
     */
    protected $message_uid;

    /**
     * @var array
     */
    protected $attachment;

    /**
     * @var object
     */
    protected $part;

    /**
     * Class Constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Config Attachment.
     *
     * @param int    $message_number
     * @param int    $message_uid
     * @param int    $attachment_id
     * @param object $part
     *
     * @return Attachment
     */
    public function config($message_number, $message_uid, $attachment_id, $part)
    {
        $this->message_number = $message_number;
        $this->message_uid = $message_uid;
        $this->attachment['index'] = $attachment_id;
        $this->part = $part;

        $this->parseParts();

        return $this;
    }

    /**
     * Get Attachment Property.
     *
     * @param string $key
     * @param bool   $default
     *
     * @return mixed
     */
    public function get($key, $default = false)
    {
        return (isset($this->attachment[$key])) ? $this->attachment[$key] : $default;
    }

    /**
     * Get Filename.
     *
     * @return mixed
     */
    public function getFilename()
    {
        return $this->get('filename', false);
    }

    /**
     * Get Extension.
     *
     * @return mixed
     */
    public function getExtension()
    {
        return $this->get('extension', false);
    }

    /**
     * Get Size.
     *
     * @return mixed
     */
    public function getSize()
    {
        return $this->get('size', false);
    }

    /**
     * Get Encoding.
     *
     * @return mixed
     */
    public function getEncoding()
    {
        return $this->get('encoding', false);
    }

    /**
     * Get Bytes.
     *
     * @return mixed
     */
    public function getBytes()
    {
        return $this->get('bytes', false);
    }

    /**
     * Get Plain Body.
     *
     * @return mixed
     */
    public function getPlainBody()
    {
        if ($this->get('plain_body')) {
            return $this->get('plain_body');
        }

        $this->attachment['plain_body'] = imap_fetchbody(
            $this->connection->getStream(),
            $this->message_number,
            $this->attachment['index']
        );

        return $this->get('plain_body');
    }

    /**
     * Get Body.
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function getBody()
    {
        if ($this->get('body')) {
            return $this->get('body');
        }

        switch ($this->getEncoding()) {
            case 2: // BINARY
                $this->attachment['body'] = $this->getPlainBody();

                return $this->get('body');

            case 3: // BASE-64
                $this->attachment['body'] = base64_decode($this->getPlainBody(), true);

                return $this->get('body');

            case 4: // QUOTED-PRINTABLE
                $this->attachment['body'] = imap_qprint($this->getPlainBody());

                return $this->get('body');
        }

        throw new \Exception(sprintf('Encoding failed: Unknown encoding %s.', $this->getEncoding()));
    }

    /**
     * Store File.
     *
     * @param string $path
     * @param bool   $file_name
     *
     * @return bool
     */
    public function store($path, $file_name = false)
    {
        $file_name = ($file_name) ? $file_name : "{$this->getFilename()}.{$this->getExtension()}";
        $path = rtrim($path, '/').'/';

        return (bool) file_put_contents($path.$file_name, $this->getBody());
    }

    /**
     * Parse Parts.
     *
     * @return bool
     */
    protected function parseParts()
    {
        if ((\count($this->attachment) > 2)) {
            return true;
        }

        $this->attachment['type'] = (isset($this->part->type)) ? $this->part->type : false;
        $this->attachment['encoding'] = (isset($this->part->encoding)) ? $this->part->encoding : false;
        $this->attachment['ifsubtype'] = (isset($this->part->ifsubtype)) ? $this->part->ifsubtype : false;
        $this->attachment['subtype'] = (isset($this->part->subtype)) ? $this->part->subtype : false;
        $this->attachment['ifdescription'] = (isset($this->part->ifdescription)) ? $this->part->ifdescription : false;
        $this->attachment['ifid'] = (isset($this->part->ifid)) ? $this->part->ifid : false;
        $this->attachment['id'] = (isset($this->part->id)) ? $this->part->id : false;
        $this->attachment['bytes'] = (isset($this->part->bytes)) ? $this->part->bytes : false;
        $this->attachment['size'] = (isset($this->part->bytes)) ? $this->part->bytes : false;
        $this->attachment['ifdisposition'] = (isset($this->part->ifdisposition)) ? $this->part->ifdisposition : false;
        $this->attachment['disposition'] = (isset($this->part->disposition)) ? $this->part->disposition : false;
        $this->attachment['ifdparameters'] = (isset($this->part->ifdparameters)) ? $this->part->ifdparameters : false;
        $this->attachment['ifparameters'] = (isset($this->part->ifparameters)) ? $this->part->ifparameters : false;

        if (\is_array($this->part->dparameters)) {
            foreach ($this->part->dparameters as $obj) {
                if (\in_array(mb_strtolower($obj->attribute), ['filename', 'name'], true)) {
                    $this->attachment[mb_strtolower($obj->attribute)] = pathinfo($obj->value, PATHINFO_FILENAME);
                    $this->attachment['extension'] = pathinfo($obj->value, PATHINFO_EXTENSION);
                }
            }
        }

        if (\is_array($this->part->parameters)) {
            foreach ($this->part->parameters as $obj) {
                if (\in_array(mb_strtolower($obj->attribute), ['filename', 'name'], true)) {
                    $this->attachment[mb_strtolower($obj->attribute)] = pathinfo($obj->value, PATHINFO_FILENAME);
                    $this->attachment['extension'] = pathinfo($obj->value, PATHINFO_EXTENSION);
                }
            }
        }

        return true;
    }
}

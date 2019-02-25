<?php
/**
 * @author clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core\Message;

use Clivern\Imap\Core\Connection;

/**
 * Body Class
 *
 * @package Clivern\Imap\Core\Message
 */
class Body
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var integer
     */
    protected $message_number;

    /**
     * @var integer
     */
    protected $message_uid;

    /**
     * @var integer
     */
    protected $encoding;

    /**
     * @var string
     */
    protected $message = '';


    /**
     * Class Constructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Config Body
     *
     * @param integer $message_number
     * @param integer $message_uid
     * @return Body
     */
    public function config($message_number, $message_uid)
    {
        $this->message_number = $message_number;
        $this->message_uid = $message_uid;

        return $this;
    }

    /**
     * Get Message
     *
     * @param  integer $option
     * @return string
     */
    public function getMessage($option = 2)
    {
        if( !empty($this->message) ){
            return $this->message;
        }

        $structure = imap_fetchstructure($this->connection->getStream(), $this->message_number);

        if (isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];
            $this->message = imap_fetchbody($this->connection->getStream(),$this->message_number , $option);


            $this->encoding = $part->encoding;

            if($part->encoding == 3) {
                $this->message = imap_base64($this->message);
            } elseif($part->encoding == 1) {
                $this->message = imap_8bit($this->message);
            } else {
                $this->message = imap_qprint($this->message);
            }
        } else {
            $this->message = imap_body($this->connection->getStream(), $this->message_number, $option);
        }

        return $this->message;
    }

    /**
     * Get Encoding
     *
     * @return integer
     */
    public function getEncoding()
    {
        return $this->encoding;
    }
}

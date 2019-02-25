<?php

/*
 * This file is part of the Imap PHP package.
 * (c) Clivern <hello@clivern.com>
 */

namespace Clivern\Imap\Core;

use Clivern\Imap\Core\Exception\AuthenticationFailedException;

/**
 * Connection Class.
 */
class Connection
{
    /**
     * @var string
     */
    protected $server;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $flag;

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var mixed
     */
    protected $stream;

    /**
     * @var mixed
     */
    protected $timeout_type;

    /**
     * @var mixed
     */
    protected $timeout;

    /**
     * Class Constructor.
     *
     * @param string $server
     * @param string $port
     * @param string $email
     * @param string $password
     * @param string $flag
     * @param string $folder
     */
    public function __construct($server, $port, $email, $password, $flag = '/ssl', $folder = 'INBOX')
    {
        $this->server = $server;
        $this->port = $port;
        $this->email = $email;
        $this->password = $password;
        $this->flag = $flag;
        $this->folder = $folder;
    }

    /**
     * Connect to IMAP Email.
     *
     * @throws AuthenticationFailedException
     *
     * @return Connection
     */
    public function connect()
    {
        try {
            $this->stream = imap_open(
                '{'.$this->server.':'.$this->port.$this->flag.'}'.$this->folder,
                $this->email,
                $this->password
            );
        } catch (\Exception $e) {
            throw new AuthenticationFailedException('Error! Connecting to Imap Email.');
        }

        return $this;
    }

    public function reconnect($folder = 'INBOX')
    {
        try {
            imap_reopen($this->stream, '{'.$this->server.':'.$this->port.$this->flag.'}'.$folder);
        } catch (\Exception $e) {
            throw new AuthenticationFailedException('Error! Connecting to Imap Email.');
        }
    }

    public function survive($folder = 'INBOX')
    {
        if (!$this->ping() || ($this->folder !== $folder)) {
            $this->reconnect($folder);
        }
    }

    /**
     * Set Timeout.
     *
     * @param string $timeout_type it may be IMAP_OPENTIMEOUT, IMAP_READTIMEOUT, IMAP_WRITETIMEOUT, or IMAP_CLOSETIMEOUT
     * @param int    $timeout      time in seconds or -1
     */
    public function setTimeout($timeout_type, $timeout)
    {
        $this->timeout_type = $timeout_type;
        $this->timeout = $timeout;

        return (bool) imap_timeout($timeout_type, $timeout);
    }

    /**
     * Get Stream.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get Server.
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Check Connection.
     *
     * @return bool
     */
    public function checkConnection()
    {
        return null !== $this->stream && imap_ping($this->stream);
    }

    /**
     * Get Quota.
     *
     * @param string $folder
     *
     * @return array
     */
    public function getQuota($folder = 'INBOX')
    {
        $data = imap_get_quotaroot($this->stream, $folder);

        return [
            'usage' => (isset($data['usage'])) ? $data['usage'] : false,
            'limit' => (isset($data['limit'])) ? $data['limit'] : false,
        ];
    }

    /**
     * Get Status.
     *
     * @param string $folder
     * @param string $flag
     *
     * @return array
     */
    public function getStatus($folder = 'INBOX', $flag = SA_ALL)
    {
        $data = imap_status($this->stream, '{'.$this->server.'}'.$folder, $flag);

        return [
            'flags' => (isset($data->flags)) ? $data->flags : false,
            'messages' => (isset($data->messages)) ? $data->messages : false,
            'recent' => (isset($data->recent)) ? $data->recent : false,
            'unseen' => (isset($data->unseen)) ? $data->unseen : false,
            'uidnext' => (isset($data->uidnext)) ? $data->uidnext : false,
            'uidvalidity' => (isset($data->uidvalidity)) ? $data->uidvalidity : false,
        ];
    }

    /**
     * Check MailBox Data.
     *
     * @return array
     */
    public function check()
    {
        $data = imap_check($this->stream);

        return [
            'date' => (isset($data->Date)) ? $data->Date : false,
            'driver' => (isset($data->Driver)) ? $data->Driver : false,
            'mailbox' => (isset($data->Mailbox)) ? $data->Mailbox : false,
            'nmsgs' => (isset($data->Nmsgs)) ? $data->Nmsgs : false,
            'recent' => (isset($data->Recent)) ? $data->Recent : false,
        ];
    }

    /**
     * Ping Connection.
     *
     * @return bool
     */
    public function ping()
    {
        return (bool) imap_ping($this->stream);
    }

    /**
     * Get Errors.
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = imap_errors();

        return (\is_array($errors)) ? $errors : [];
    }

    /**
     * Get Alerts.
     *
     * @return array
     */
    public function getAlerts()
    {
        $alerts = imap_alerts();

        return (\is_array($alerts)) ? $alerts : [];
    }

    /**
     * Get Last Error.
     *
     * @return string
     */
    public function getLastError()
    {
        $error = imap_last_error();

        return !(empty($error)) ? $error : '';
    }

    /**
     * Disconnect.
     *
     * @param int $flag
     *
     * @return bool
     */
    public function disconnect($flag = \CL_EXPUNGE)
    {
        if (null !== $this->stream && imap_ping($this->stream)) {
            if (imap_close($this->stream, $flag)) {
                $this->stream = null;

                return true;
            }

            return false;
        }

        return false;
    }
}

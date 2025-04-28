<?php
//https://github.com/ringcentral/ringcentral-php/blob/master/src/Platform/Platform.php

class RingCentralcURL{
    /** @var string */
    protected $_server;

    /** @var string */
    protected $_clientId;

    /** @var string */
    protected $_clientSecret;

    /** @var string */
    protected $_appName;

    /** @var string */
    protected $_appVersion;

    /** @var string */
    protected $_userAgent;

    /** @var Auth */
    protected $_auth;

    /** @var Client */
    protected $_client;

    /**
     * Platform constructor.
     * @param Client $client
     * @param string $clientId
     * @param string $clientSecret
     * @param string $server
     * @param string $appName
     * @param string $appVersion
     */
    public function __construct(Client $client, $clientId, $clientSecret, $server, $appName = '', $appVersion = '')
    {

        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;
        $this->_appName = empty($appName) ? 'Unnamed' : $appName;
        $this->_appVersion = empty($appVersion) ? '0.0.0' : $appVersion;

        $this->_server = $server;

        $this->_auth = new Auth();
        $this->_client = $client;

        $this->_userAgent = (!empty($this->_appName) ? ($this->_appName . (!empty($this->_appVersion) ? '/' . $this->_appVersion : '') . ' ') : '') .
                            php_uname('s') . '/' . php_uname('r') . ' ' .
                            'PHP/' . phpversion() . ' ' .
                            'RCPHPSDK/' . SDK::VERSION;

    }
}
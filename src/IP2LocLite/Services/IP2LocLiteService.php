<?php

namespace NemC\IP2LocLite\Services;

use Config,
    GuzzleHttp\Client as CurlClient;

class IP2LocLiteService
{
    protected $curlClient;
    protected $ip2LocationUsername;
    protected $ip2LocationPassword;
    protected $ip2LocationLoginPath;

    protected $autoLoginCookieName;

    public function __construct(CurlClient $curlClient)
    {
        $this->curlClient = $curlClient;
        $this->ip2LocationLoginPath = Config::get('IP2LocLite::loginPath');
        $this->ip2LocationUsername = Config::get('IP2LocLite::user.username');
        $this->ip2LocationPassword = Config::get('IP2LocLite::user.password');

        $this->autoLoginCookieName = Config::get('IP2LocLite::curl.cookieName');
    }

    public function login()
    {
        $this->curlClient->post($this->ip2LocationLoginPath, [
            'headers' => [],
            'allow_redirect' => true,
            'timeout' => 5,
        ]);
    }
}
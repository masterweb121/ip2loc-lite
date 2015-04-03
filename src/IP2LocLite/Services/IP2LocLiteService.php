<?php

namespace NemC\IP2LocLite\Services;

use Illuminate\Support\Facades\Config,
    Illuminate\Support\Facades\File,
    GuzzleHttp\Client as CurlClient,
    GuzzleHttp\Exception\RequestException,
    GuzzleHttp\Cookie\FileCookieJar as CurlCookieJar,
    NemC\IP2LocLite\Exceptions\NotOkResponseException,
    NemC\IP2LocLite\Exceptions\NotLoggedInResponseException,
    NemC\IP2LocLite\Exceptions\UnsupportedDatabaseCommandException,
    NemC\IP2LocLite\Exceptions\ArchiveMissingException;

class IP2LocLiteService
{
    protected $curlClient;
    protected $cookieJar;
    protected $username;
    protected $password;
    protected $rememberMe;

    protected $loginPagePath;
    protected $accountPagePath;
    protected $downloadPagePath;

    protected $storagePath;

    protected $autoLoginCookie;

    public function __construct(CurlClient $curlClient)
    {
        $this->username = Config::get('ip2loc-lite.username');
        $this->password = Config::get('ip2loc-lite.password');
        $this->rememberMe = Config::get('ip2loc-lite.rememberMe');
        if ($this->rememberMe !== 'on') {
            $this->rememberMe = 'off';
        }

        $this->loginPagePath = Config::get('ip2loc-lite::config.loginPagePath');
        $this->accountPagePath = Config::get('ip2loc-lite::config.accountPagePath');
        $this->downloadPagePath = Config::get('ip2loc-lite::config.downloadPagePath');

        $this->storagePath = Config::get('ip2loc-lite::config.storagePath');

        $this->autoLoginCookie = Config::get('ip2loc-lite::config.cookiePath');

        $this->curlClient = $curlClient;
        /**
         * TODO: find way to detach this from constructor
         */
        $this->cookieJar = new CurlCookieJar($this->autoLoginCookie);
    }

    public function isOnline()
    {
        try {
            $response = $this->curlClient->get($this->loginPagePath, [
                'timeout' => 3,
            ]);
        } catch(RequestException $e) {
            throw new NotOkResponseException($e->getMessage(), $e->getCode(), $e);
        }
        if ($response->getReasonPhrase() !== 'OK') {
            throw new NotOkResponseException();
        }

        return true;
    }

    public function isLoggedIn()
    {
        //check is user logged in - try to open account page
        $response = $this->curlClient->get($this->accountPagePath, [
            'timeout' => 3,
            'cookies' => $this->cookieJar,
        ]);
        if ($response->getReasonPhrase() !== 'OK') {
            throw new NotLoggedInResponseException();
        }
    }

    /**
     * @return CurlCookieJar
     * @throws NotLoggedInResponseException
     */
    public function login()
    {
        $this->isOnline();

        $this->curlClient->post($this->loginPagePath, [
            'headers' => [],
            'body' => [
                'emailAddress' => $this->username,
                'password' => $this->password,
                'rememberMe' => $this->rememberMe,
            ],
            'timeout' => 5,
            'cookies' => $this->cookieJar,
        ]);

        $this->isLoggedIn();

        return $this->cookieJar;
    }

    public function downloadCsv($database)
    {
        $this->isLoggedIn();
        $this->isSupportedDatabase($database);

        $response = $this->curlClient->get($this->downloadPagePath, [
            'query' => [
                'code' => $database,
            ],
            'timeout' => 30,
            'cookies' => $this->cookieJar,
        ]);

        //write file to downloads
        $databaseFile = $this->storagePath . '/downloads/' . $database . '.csv.zip';
        if (File::exists($databaseFile) === true) {
            unlink($databaseFile);
        }
        File::put($databaseFile, $response->getBody());
    }

    public function isArchive($database)
    {
        $databaseFile = $this->storagePath . '/downloads/' . $database . '.csv.zip';
        if (File::exists($databaseFile) === false) {
            throw new ArchiveMissingException();
        }

        return true;
    }

    public function isSupportedDatabase($database)
    {
        $supportedDatabases = Config::get('ip2loc-lite::databases');
        if (in_array($database, $supportedDatabases) === false) {
            throw new UnsupportedDatabaseCommandException;
        }

        return true;
    }

    public function databaseToCsvName($database)
    {
        $dbVersion = str_replace('LITE', '', $database);
        return 'IP2LOCATION-LITE-' . $dbVersion . '.CSV';
    }

    public function databaseToRepoName($database)
    {
        $dbVersion = str_replace('LITE', '', $database);
        return $dbVersion;
    }
}
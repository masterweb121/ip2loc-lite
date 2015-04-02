<?php

namespace NemC\IP2LocLite\Commands;

use Illuminate\Console\Command,
    NemC\IP2LocLite\Services\IP2LocLiteService;

class LoginCommand extends Command
{
    protected $name = 'ip2loclite:login';
    protected $description = 'Login to IP2Location user panel and save login cookie';

    protected $ip2LocLite;

    public function __construct(IP2LocLiteService $IP2LocLiteService)
    {
        parent::__construct();
        $this->ip2LocLite = $IP2LocLiteService;
    }

    public function fire()
    {
        $cookieJar = $this->ip2LocLite->login();
        $this->info(print_r($cookieJar->toArray(), true));
    }
}
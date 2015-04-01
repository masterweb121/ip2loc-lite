<?php

namespace NemC\IP2LocLite\Providers;

use Illuminate\Support\ServiceProvider,
    NemC\IP2LocLite\Commands\LoginCommand,
    NemC\IP2LocLite\Commands\DownloadCsvCommand;

class IP2LocLiteCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerLoginCommand();
        $this->registerDownloadCsv();
    }


}
<?php

namespace NemC\IP2LocLite\Providers;

use Illuminate\Support\ServiceProvider,
    NemC\IP2LocLite\Commands\LoginCommand,
    NemC\IP2LocLite\Commands\DownloadCsvCommand;

class IP2LocLiteServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->registerLoginCommand();
        $this->registerDownloadCsv();
    }

    protected function registerLoginCommand()
    {
        $this->app['nemc_ip2loclite_login'] = $this->app->share(function ($app) {
            return new LoginCommand(
                $app->make('NemC\IP2LocLite\Services\IP2LocLiteService')
            );
        });
        $this->commands('nemc_ip2loclite_login');
    }

    protected function registerDownloadCsv()
    {
        $this->app['nemc_ip2loclite_download_csv'] = $this->app->share(function ($app) {
            return new DownloadCsvCommand(
                $app->make('NemC\IP2LocLite\Services\IP2LocLiteService')
            );
        });
        $this->commands('nemc_ip2loclite_download_csv');
    }
}
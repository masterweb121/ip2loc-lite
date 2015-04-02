<?php

namespace NemC\IP2LocLite\Commands;

use Illuminate\Console\Command,
    Symfony\Component\Console\Input\InputArgument,
    NemC\IP2LocLite\Services\IP2LocLiteService,
    NemC\IP2LocLite\Exceptions\NotLoggedInResponseException,
    NemC\IP2LocLite\Exceptions\UnsupportedDatabaseCommandException;

class DownloadCsvCommand extends Command
{
    protected $name = 'ip2loclite:download-csv';
    protected $description = 'Login to IP2Location user panel and download required csv';

    protected $ip2LocLite;

    public function __construct(IP2LocLiteService $IP2LocLiteService)
    {
        parent::__construct();
        $this->ip2LocLite = $IP2LocLiteService;
    }

    public function fire()
    {
        $database = $this->argument('database');
        try {
            $this->ip2LocLite->isSupportedDatabase($database);
        } catch (UnsupportedDatabaseCommandException $e) {
            $this->error('Free IP2Location database "' . $database . '"" is not supported by IP2LocLite at this point');
            return false;
        }

        try {
            $this->ip2LocLite->login();
        } catch (NotLoggedInResponseException $e) {
            $this->error('Could not log you in with user authentication details provided');
            return false;
        }

        $this->ip2LocLite->downloadCsv($database);

        $this->info('Latest version of IP2Location database ' . $database . ' has been downloaded');
    }

    public function getArguments()
    {
        return array(
            array('database', InputArgument::REQUIRED, 'Database name to download'),
        );
    }
}
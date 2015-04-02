<?php

namespace NemC\IP2LocLite\Commands;

use ZipArchive,
    Illuminate\Console\Command,
    Illuminate\Support\Facades\Config,
    Symfony\Component\Console\Input\InputArgument,
    NemC\IP2LocLite\Services\IP2LocLiteService,
    NemC\IP2LocLite\Repositories\IP2LocRepository,
    NemC\IP2LocLite\Exceptions\UnsupportedDatabaseCommandException,
    NemC\IP2LocLite\Exceptions\ArchiveMissingException;

class ImportCsvCommand extends Command
{
    protected $name = 'ip2loclite:import-csv';
    protected $description = 'Import previously downloaded csv into database';

    protected $ip2LocLite;
    protected $zipper;
    protected $ip2LocRepo;

    public function __construct(IP2LocLiteService $IP2LocLiteService, IP2LocRepository $IP2LocRepository, ZipArchive $zipArchive)
    {
        parent::__construct();
        $this->ip2LocLite = $IP2LocLiteService;
        $this->zipper = $zipArchive;
        $this->ip2LocRepo = $IP2LocRepository;
    }

    public function fire()
    {
        $database = $this->argument('database');
        try {
            $this->ip2LocLite->isSupportedDatabase($database);
        } catch (UnsupportedDatabaseCommandException $e) {
            $this->error('Free IP2Location database "' . $database . '" is not supported by IP2LocLite at this point');
            return false;
        }

        //check does file exists
        try {
            $this->ip2LocLite->isArchive($database);
        } catch (ArchiveMissingException $e) {
            $this->error('Free IP2Location database "' . $database . '" is not found in downloads');
            return false;
        }

        $downloadsPath = Config::get('ip2loc-lite::config.storagePath') . '/downloads/';
        $this->zipper->open($downloadsPath . $database . '.csv.zip');
        $this->zipper->extractTo($downloadsPath);
        $this->zipper->close();

        $csvFileName = $this->ip2LocLite->databaseToCsvName($database);
        $csvFilePath = $downloadsPath . $csvFileName;

        $csvHandle = fopen($csvFilePath, 'r');
        if ($csvHandle === false) {
            $this->error('Can\'t open file ' . $csvFileName . ' for import');
            return false;
        }

        $this->ip2LocLite->loadRepository($database);
        $this->ip2LocRepo->createTable();
        while ($data = fgetcsv($csvHandle)) {
            $this->ip2LocRepo->insertOnDuplicateKeyUpdate($data);
            print_r($data);
        }
    }

    public function getArguments()
    {
        return array(
            array('database', InputArgument::REQUIRED, 'Database name to import'),
        );
    }
}
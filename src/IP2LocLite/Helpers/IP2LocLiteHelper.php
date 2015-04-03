<?php

namespace NemC\IP2LocLite\Helpers;

use Illuminate\Support\Facades\Config,
    NemC\IP2LocLite\Services\IP2LocLiteService as Service,
    NemC\IP2LocLite\Storage\IP2LocStorageManager as StorageManager;

class IP2LocLiteHelper
{
    private $ip2LocLite;
    private $storageManager;

    public function __construct(Service $service, StorageManager $storageManager)
    {
        $this->ip2LocLite = $service;
        $this->storageManager = $storageManager;
    }

    public function getForLongIp($longIp)
    {
        $database = Config::get('ip2loc-lite.database');
        $repo = $this->storageManager->getRepositoryForDatabase($this->ip2LocLite->databaseToRepoName($database));

        return $repo->getByLongIp($longIp);
    }
}
<?php

namespace NemC\IP2LocLite\Storage;

use Illuminate\Support\Facades\Config,
    NemC\IP2LocLite\Storage\Mysql\DB3;

class IP2LocStorageManager
{
    private $instances = [];

    public function getRepositoryForDatabase($database)
    {
        if (isset($this->instances[$database]) === false) {
            $classNamespace = 'NemC\\IP2LocLite\\Storage\\Mysql\\' . $database;
            $this->instances[$database] = new $classNamespace(Config::get('ip2loc-lite::config.table_prefix'));
        }

        return $this->instances[$database];
    }
}
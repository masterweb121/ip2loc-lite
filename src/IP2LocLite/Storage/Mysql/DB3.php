<?php

namespace NemC\IP2LocLite\Storage\Mysql;

use Illuminate\Support\Facades\DB,
    Illuminate\Support\Config,
    NemC\IP2LocLite\Storage\IP2LocStorageInterface;

class DB3 implements IP2LocStorageInterface
{
    protected $tablePrefix;
    protected $tableName;
    public function __construct($tablePrefix)
    {
        $this->tablePrefix = $tablePrefix;
        $this->tableName = $tablePrefix . 'db3';
    }
    /**
     *
     */
    public function createTable()
    {
        DB::connection()->disableQueryLog();

        DB::statement("
              CREATE TABLE IF NOT EXISTS {$this->tableName} (
              long_from int(11) NOT NULL,
              long_to int(11) NOT NULL,
              country_iso2 varchar(2) NOT NULL,
              country_name varchar(100) NOT NULL,
              region_name varchar(100) NOT NULL,
              city_name varchar(100) NOT NULL,
              PRIMARY KEY (long_from,long_to)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    /**
     * @param $data [longFrom, longTo, countryIso2, countryName, regionName, cityName]
     */
    public function insertOnDuplicateKeyUpdate($data)
    {
        DB::insert("
            INSERT INTO {$this->tableName}
              (long_from, long_to, country_iso2, country_name, region_name, city_name)
              VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
              country_iso2 = VALUES(country_iso2),
              country_name = VALUES(country_name),
              region_name = VALUES(region_name),
              city_name = VALUES(city_name)
        ", $data);
    }

    /**
     * @param $longIp
     * @return null
     */
    public function getByLongIp($longIp)
    {
        $results = DB::select("
            SELECT *
            FROM {$this->tableName}
            WHERE long_from <= ?
            AND long_to >= ?
            LIMIT 1
        ", [$longIp, $longIp]);

        if (count($results) > 0) {
            $row = $results[0];
        } else {
            $row = null;
        }

        return $row;
    }
}
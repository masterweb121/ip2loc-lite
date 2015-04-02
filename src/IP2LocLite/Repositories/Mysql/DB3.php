<?php

namespace NemC\IP2LocLite\Repositories\Mysql;

use Illuminate\Support\Facades\DB,
    Illuminate\Support\Config,
    NemC\IP2LocLite\Repositories\IP2LocRepository;

class DB3 implements IP2LocRepository
{
    /**
     *
     */
    public function createTable()
    {
        $tableName = Config::get('ip2loc-lite.config.table_prefix') . 'db3';
        DB::connection()->disableQueryLog();

        DB::statement("
              CREATE TABLE IF NOT EXISTS $tableName (
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
        $tableName = Config::get('ip2loc-lite.config.table_prefix') . 'db3';

        DB::insert("
            INSERT INTO $tableName
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
        $tableName = Config::get('ip2loc-lite.config.table_prefix') . 'db3';

        $results = DB::select("
            SELECT *
            FROM $tableName
            WHERE long_from >= ?
            AND long_to <= ?
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
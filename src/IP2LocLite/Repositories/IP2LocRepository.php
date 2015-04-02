<?php

namespace NemC\IP2LocLite\Repositories;

interface IP2LocRepository
{
    public function createTable();
    public function insertOnDuplicateKeyUpdate($data);
    public function getByLongIp($longIp);
}
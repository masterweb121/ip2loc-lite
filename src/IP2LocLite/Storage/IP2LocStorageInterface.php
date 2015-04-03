<?php

namespace NemC\IP2LocLite\Storage;

interface IP2LocStorageInterface
{
    public function __construct($tablePrefix);
    public function createTable();
    public function insertOnDuplicateKeyUpdate($data);
    public function getByLongIp($longIp);
}
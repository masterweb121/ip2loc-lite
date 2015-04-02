<?php

/**
 * @group NemC\IP2LocLite\Tests
 * @author NemC <nemc@codeanvil.co>
 */

use Illuminate\Foundation\Testing\TestCase,
    GuzzleHttp\Client as CurlClient,
    NemC\IP2LocLite\Services\IP2LocLiteService;

class IP2LocLiteServiceTest extends TestCase
{
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';
        $basePath = __DIR__ . '/../../../../../../../bootstrap/start.php';
        return require $basePath;
    }

    public function testIsOnline()
    {
        $curlClient = new CurlClient();
        $ip2LocLiteService = new IP2LocLiteService($curlClient);

        $this->assertEquals(true, $ip2LocLiteService->isOnline(), 'Looks like /login is offline or missing');
    }

}
<?php

use Craft\ConfigService;

class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ConfigService|PHPUnit_Framework_MockObject_MockObject
     */
    protected $configService;


    protected function setUp()
    {
        $this->configService = $this->createMock(ConfigService::class);
        registerService('config', $this->configService);
    }
}

<?php

class CacheHeaderControlServiceTest extends BaseTestCase
{
    public function testInstance()
    {
        $instance = new \Craft\CacheHeaderControlService();
        $this->assertInstanceOf(\Craft\BaseApplicationComponent::class, $instance);
    }

    public function testGetConfig()
    {
        $instance = new \Craft\CacheHeaderControlService();
        $this->configService->method('get')->with('foo', 'CacheHeaderControl')->willReturn('bar');
        $this->configService->expects($this->once())->method('get')->with('foo', 'CacheHeaderControl');
        $this->assertEquals('bar', $instance->getConfig('foo'));
    }
}

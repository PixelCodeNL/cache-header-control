<?php

class CacheHeaderControlExtensionTest extends BaseTestCase
{
    public function testExtension()
    {
        $extension = new \Craft\CacheHeaderControlExtension();
        $this->assertInstanceOf(Twig_Extension::class, $extension);
    }

    public function testTokenParsers()
    {
        $extension = new \Craft\CacheHeaderControlExtension();
        $tokenParsers = $extension->getTokenParsers();
        $this->assertContainsOnlyInstancesOf(Twig_TokenParser::class, $tokenParsers);
        $this->assertCount(1, $tokenParsers);
        $httpCacheTokenParser = $tokenParsers[0];
        $this->assertInstanceOf(\Craft\HttpCacheTokenParser::class, $httpCacheTokenParser);
    }

    public function testName()
    {
        $extension = new \Craft\CacheHeaderControlExtension();
        $this->assertEquals('cache_header_control', $extension->getName());
    }
}

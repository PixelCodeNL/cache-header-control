<?php

class HttpCacheTokenParserTest extends BaseTestCase
{
    public function testInstance()
    {
        $parser = new \Craft\HttpCacheTokenParser();
        $this->assertInstanceOf(Twig_TokenParser::class, $parser);
    }

    public function testTagName()
    {
        $parser = new \Craft\HttpCacheTokenParser();
        $this->assertEquals('http_cache', $parser->getTag());
    }
}

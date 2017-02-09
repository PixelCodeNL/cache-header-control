<?php

use Craft\HttpCacheTokenParser;

class HttpCacheTokenParserTest extends BaseTestCase
{
    /**
     * @var \Craft\CacheHeaderControlService|PHPUnit_Framework_MockObject_MockObject
     */
    private $cacheHeaderControlService;

    /**
     * @var Twig_Parser|PHPUnit_Framework_MockObject_MockObject
     */
    private $parser;

    /**
     * @var Twig_TokenStream|PHPUnit_Framework_MockObject_MockObject
     */
    private $tokenStream;


    protected function setUp()
    {
        parent::setUp();
        $this->cacheHeaderControlService = $this->createMock(\Craft\CacheHeaderControlService::class);
        registerService('cacheHeaderControl', $this->cacheHeaderControlService);

        $this->parser = $this->createMock(Twig_Parser::class);
        $this->tokenStream = $this->createMock(Twig_TokenStream::class);
        $this->parser->method('getStream')->willReturn($this->tokenStream);
    }


    public function testInstance()
    {
        $instance = $this->getInstance();
        $this->assertInstanceOf(Twig_TokenParser::class, $instance);
    }

    public function testTagName()
    {
        $instance = $this->getInstance();
        $this->assertEquals('http_cache', $instance->getTag());
    }

    public function testParseWithDefaultConfig()
    {
        $this->setUpConfigService([
            'enableCache' => true,
            'defaultCacheExpiration' => '+15 minutes'
        ]);

        $instance = $this->getInstance();
        $token = $this->createMock(Twig_Token::class);
        $token->method('getValue')->willReturn('');
        $this->tokenStream->method('getCurrent')->willReturn($token);
        $result = $instance->parse($token);

        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $result);
        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler->expects($this->once())->method('write')->with('\Craft\HeaderHelper::setExpires(900);');
        $result->compile($compiler);
    }

    public function testParseWithFalse()
    {
        $this->setUpConfigService([
            'enableCache' => true,
            'defaultCacheExpiration' => '+15 minutes'
        ]);

        $instance = $this->getInstance();
        $token = $this->createMock(Twig_Token::class);
        $token->method('getValue')->willReturn('false');
        $this->tokenStream->method('getCurrent')->willReturn($token);
        $result = $instance->parse($token);

        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $result);
        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler->expects($this->once())->method('write')->with('\Craft\HeaderHelper::setExpires(-1);');
        $result->compile($compiler);
    }

    /**
     * @dataProvider getTimeToExpirationData
     */
    public function testParseWithCustomArguments($argument, $expectedExpiration)
    {
        $this->setUpConfigService([
            'enableCache' => true,
        ]);

        $instance = $this->getInstance();
        $token = $this->createMock(Twig_Token::class);
        $token->method('getValue')->willReturn($argument);
        $this->tokenStream->method('getCurrent')->willReturn($token);
        $result = $instance->parse($token);

        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $result);
        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler
            ->expects($this->once())
            ->method('write')
            ->with('\Craft\HeaderHelper::setExpires(' . $expectedExpiration . ');');
        $result->compile($compiler);
    }


    /**
     * @dataProvider getTimeToExpirationData
     */
    public function testParseWithCustomConfig($defaultCacheExpiration, $expectedExpiration)
    {
        $this->setUpConfigService([
            'enableCache' => true,
            'defaultCacheExpiration' => $defaultCacheExpiration
        ]);

        $instance = $this->getInstance();
        $token = $this->createMock(Twig_Token::class);
        $token->method('getValue')->willReturn('');
        $this->tokenStream->method('getCurrent')->willReturn($token);
        $result = $instance->parse($token);

        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $result);
        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler
            ->expects($this->once())
            ->method('write')
            ->with('\Craft\HeaderHelper::setExpires(' . $expectedExpiration . ');');
        $result->compile($compiler);
    }

    public function testParseWithCacheDisabled()
    {
        $this->setUpConfigService([
            'enableCache' => false,
        ]);

        $instance = $this->getInstance();
        $token = $this->createMock(Twig_Token::class);
        $token->method('getValue')->willReturn('');
        $this->tokenStream->method('getCurrent')->willReturn($token);
        $result = $instance->parse($token);

        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $result);
        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler->expects($this->once())->method('write')->with('\Craft\HeaderHelper::setExpires(-1);');
        $result->compile($compiler);
    }

    /**
     * @return HttpCacheTokenParser
     */
    private function getInstance()
    {
        $instance = new HttpCacheTokenParser();
        $instance->setParser($this->parser);

        return $instance;
    }

    /**
     * @return array
     */
    public function getTimeToExpirationData()
    {
        return [
            ['+1 hour', 3600],
            ['+1 minute', 60],
            ['+2 years', 63072000],
            ['+1 month', 2419200],
            ['+2 months', 5094000],
            ['+1 day', 86400],
            ['+10 days', 864000],
        ];
    }

    /**
     * @param array $config
     */
    private function setUpConfigService($config)
    {
        $this->cacheHeaderControlService->method('getConfig')->willReturnCallback(
            function () use ($config) {
                $key = func_get_arg(0);
                if (array_key_exists($key, $config)) {
                    return $config[$key];
                }

                return null;
            }
        );
    }
}

<?php

class HttpCacheNodeTest extends BaseTestCase
{
    public function testInstance()
    {
        $node = new \Craft\HttpCacheNode();
        $this->assertInstanceOf(\Craft\HttpCacheNode::class, $node);
    }

    public function testCompile()
    {
        $node = new \Craft\HttpCacheNode([], ['expiration' => 1000]);

        $compiler = $this->createMock(Twig_Compiler::class);
        $compiler->expects($this->once())->method('write')->with('\Craft\HeaderHelper::setExpires(1000);');

        $node->compile($compiler);
    }
}

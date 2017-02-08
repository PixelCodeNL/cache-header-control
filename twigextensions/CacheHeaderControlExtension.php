<?php

namespace Craft;

class CacheHeaderControlExtension extends \Twig_Extension
{
    /**
     * @inheritdoc
     */
    public function getTokenParsers()
    {
        return [
            new HttpCacheTokenParser()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'cache_header_control';
    }
}

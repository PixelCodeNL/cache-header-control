<?php

namespace Craft;

class CacheHeaderControlPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('HTTP cache headers control');
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @inheritdoc
     */
    public function getDeveloper()
    {
        return 'Pixel&Code';
    }

    /**
     * @inheritdoc
     */
    public function getDeveloperUrl()
    {
        return 'https://www.pixelcode.nl';
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.cacheheadercontrol.twigextensions.CacheHeaderControlExtension');
        Craft::import('plugins.cacheheadercontrol.twigextensions.Node.HttpCacheNode');
        Craft::import('plugins.cacheheadercontrol.twigextensions.TokenParser.HttpCacheTokenParser');

        return new CacheHeaderControlExtension();
    }
}

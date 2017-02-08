<?php

namespace Craft;

class CacheHeaderControlService extends BaseApplicationComponent
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getConfig($name) {
        return craft()->config->get($name, 'CacheHeaderControl');
    }
}

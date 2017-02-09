<?php

use Craft\App;

require_once 'tests/mocks/BaseApplicationComponent.php';
require_once 'tests/mocks/App.php';
require_once 'tests/mocks/ConfigService.php';
require_once 'tests/BaseTestCase.php';

require_once 'services/CacheHeaderControlService.php';
require_once 'twigextensions/CacheHeaderControlExtension.php';
require_once 'twigextensions/TokenParser/HttpCacheTokenParser.php';
require_once 'twigextensions/Node/HttpCacheNode.php';

$app = App::getInstance();

function craft()
{
    global $app;
    return $app;
}

function registerService($name, $service)
{
    global $app;
    $app->registerService($name, $service);
}

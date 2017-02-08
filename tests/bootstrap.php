<?php

require_once 'tests/mocks/BaseApplicationComponent.php';
require_once 'tests/BaseTestCase.php';

require_once 'services/CacheHeaderControlService.php';
require_once 'twigextensions/CacheHeaderControlExtension.php';
require_once 'twigextensions/TokenParser/HttpCacheTokenParser.php';
require_once 'twigextensions/Node/HttpCacheNode.php';

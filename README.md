# Craft HTTP cache header control plugin

[![Build Status](https://travis-ci.org/PixelCodeNL/cache-header-control.svg?branch=master)](https://travis-ci.org/PixelCodeNL/cache-header-control)

This plugin makes it easier to set up an Cache-Control and Expiration HTTP header from your templates.

## Installation

Install it with Composer:

```
composer require pixelcode/cacheheadercontrol
```

## Usage

Use it in your template(s):

```
{% http_cache %}
```
This will set the headers based on the plugin configuration.

```
{% http_cache false %}
```
This will disable cache for the template.


```
{% http_cache '+5 minutes' %}
```
This will set the cache expiration to 5 minutes after the current time, so the template will be cached for 5 minutes.

You can use all 'strtotime' formats here, see http://php.net/manual/en/function.strtotime.php.

## Configuration

### Options

#### enableCache

Default: `true`

Enable or disable cache headers. If this is set to 'false' and you add the 'http_cache' tag to a template, the Expiration header will get the value of {time} - 1 second.

#### defaultCacheExpiration

Default: `+15 minutes`

Default expiration used when you use '{% http_cache %}' without any custom options.

### Overwrite configuration

You can overwrite the configuration by creating a PHP file with the name 'cacheHeaderControl.php' in the 'craft/config' folder.

Example for overwriting the default expiration:

```
<?php

return [
    'defaultCacheExpiration' => '+5 minutes',
];

```

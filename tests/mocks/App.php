<?php

namespace Craft;

class App
{
    /**
     * @var array
     */
    private $services = [];


    /**
     * @return App
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * @param string $name
     * @param mixed $service
     */
    public function registerService($name, $service)
    {
        $this->services[$name] = $service;
    }

    function __get($name)
    {
        if (!array_key_exists($name, $this->services)) {
            throw new \RuntimeException(
                sprintf('Service %s not registered! Register it first with registerService()', $name)
            );
        }

        return $this->services[$name];
    }
}

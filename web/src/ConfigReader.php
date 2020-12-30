<?php

namespace Yesido;

class ConfigReader 
{
    private array $config;

    public function __construct()
    {
        $this->config = include(CONFIG);
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->config);
    }

    public function get(string $name): string
    {
        return $this->config[$name];
    }
}

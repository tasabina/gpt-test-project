<?php

namespace GptTestProject\Providers;

use Symfony\Component\Dotenv\Dotenv;

trait EnvironmentProvider
{
    /**
     * Provides value of environment variables by name
     */
    private static function getEnvironmentVariable(string $varName): ?string
    {
        if (!$varName) return null;
        
        $root = $_SERVER["PWD"];

        $dotenv = new Dotenv();
        $dotenv->load($root.'/.env');

        return $_ENV[$varName];
    }
}
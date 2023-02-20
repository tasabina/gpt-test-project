<?php

namespace GptTestProject\Providers;

use Symfony\Component\Dotenv\Dotenv;

trait EnvironmentProvider
{
    private static function getEnvironmentVariable(string $varName): ?string
    {
        if (!$varName) return null;
        
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        return $_ENV[$varName];
    }
}
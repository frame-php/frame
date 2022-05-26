<?php

namespace Framework\Components\DatabaseComponent\Factories;

use Framework\Components\DatabaseComponent\Interfaces\DatabaseProviderInterface;
use Framework\Components\DatabaseComponent\Providers\MysqlProvider;

class ProviderFactory
{
    public static function make(string $provider): ?DatabaseProviderInterface
    {
        switch ($provider) {
            case PROVIDER_DEFAULT:
            case PROVIDER_MYSQL:
                return new MysqlProvider();
            default:
                return null;
        }
    }
}

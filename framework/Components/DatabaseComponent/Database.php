<?php

namespace Framework\Components\DatabaseComponent;

use Framework\Components\DatabaseComponent\Exceptions\DatabaseEmptyProviderException;
use Framework\Components\DatabaseComponent\Exceptions\DatabaseException;
use Framework\Components\DatabaseComponent\Factories\ProviderFactory;
use Framework\Components\DatabaseComponent\Interfaces\DatabaseProviderInterface;

class Database
{
    /**
     * @var DatabaseManager|null
     */
    private static $manager = null;

    public static function init(string $provider, array $config): void
    {
        self::manager(
            ProviderFactory::make($provider),
            $config
        );
    }

    public static function manager(?DatabaseProviderInterface $provider = null, array $config = []): DatabaseManager
    {
        if (self::$manager === null)
        {
            if ($provider === null || empty($config)) {
                throw new DatabaseException('Passed empty parameters when initializing the database manager!');
            }
            self::$manager = new DatabaseManager($provider, $config);
        }
        return self::$manager;
    }

    public static function close(): void
    {
        self::manager()->disconnectIfNeed();
    }

    public static function name(): string
    {
        return self::manager()->name();
    }

    public static function isConnected(): bool
    {
        return self::manager()->isConnected();
    }

    /**
     * @param string $query
     * @param string ...$args
     * @return mixed
     */
    public static function execute(string $query, ...$args)
    {
        return self::manager()->execute($query, ...$args);
    }

    public static function connectIfNeed(): void
    {
        self::manager()->connectIfNeed();
    }

    public static function disconnectIfNeed(): void
    {
        self::manager()->disconnectIfNeed();
    }

    /**
     * @throws DatabaseEmptyProviderException
     */
    public static function checkProvider(): void
    {
        self::manager()->checkProvider();
    }
}

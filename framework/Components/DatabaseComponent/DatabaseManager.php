<?php

namespace Framework\Components\DatabaseComponent;

use Framework\Components\DatabaseComponent\Exceptions\DatabaseEmptyProviderException;
use Framework\Components\DatabaseComponent\Exceptions\DatabaseQueryException;
use Framework\Components\DatabaseComponent\Interfaces\DatabaseProviderInterface;
use Throwable;

class DatabaseManager
{
    /**
     * @var DatabaseProviderInterface|null
     */
    private $provider;

    /**
     * @var array
     */
    private $config;

    public function __construct(DatabaseProviderInterface $provider, array $config)
    {
        $this->provider = $provider;
        $this->config = $config;
    }

    public function close(): void
    {
        $this->disconnectIfNeed();
    }

    public function name(): string
    {
        return $this->provider->name();
    }

    public function isConnected(): bool
    {
        return $this->provider->isConnected();
    }

    /**
     * @param string $query
     * @param string ...$args
     * @return mixed
     */
    public function execute(string $query, ...$args)
    {
        $this->connectIfNeed();
        try {
            return $this->provider->execute($query, ...$args);
        } catch (Throwable $ex) {
            throw new DatabaseQueryException(sprintf(
                "Failed to query database: '%s', reason: '%s'", $query, $ex->getMessage()
            ), 0, $ex);
        }
    }

    public function connectIfNeed(): void
    {
        $this->checkProvider();

        if (!$this->isConnected()) {
            $this->provider->connect($this->config);
        }
    }

    public function disconnectIfNeed(): void
    {
        try {
            $this->checkProvider();

            if ($this->isConnected()) {
                $this->provider->disconnect();
            }
        } catch (DatabaseEmptyProviderException $ex) {
        }
    }

    /**
     * @throws DatabaseEmptyProviderException
     */
    public function checkProvider(): void
    {
        if (!$this->provider instanceof DatabaseProviderInterface) {
            throw new DatabaseEmptyProviderException('Database provider is null!');
        }
    }
}

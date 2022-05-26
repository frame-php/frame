<?php

namespace Framework\Components\DatabaseComponent\Providers;

use Framework\Components\DatabaseComponent\Exceptions\DatabaseConfigException;
use Framework\Components\DatabaseComponent\Exceptions\DatabaseConnectException;
use Framework\Components\DatabaseComponent\Exceptions\DatabaseQueryException;
use Framework\Components\DatabaseComponent\Interfaces\DatabaseProviderInterface;
use mysqli;
use mysqli_result;

class MysqlProvider implements DatabaseProviderInterface
{
    /**
     * @var mysqli
     */
    private $client;

    public function name(): string
    {
        return PROVIDER_MYSQL;
    }

    /**
     * @param array $config
     * @throws DatabaseConfigException
     * @throws DatabaseConnectException
     */
    public function connect(array $config): void
    {
        $this->checkConfig($config);

        $client = mysqli_connect(
            $config['host'],
            $config['user'],
            $config['pass']
        );

        if (!$client instanceof mysqli) {
            throw new DatabaseConnectException(mysqli_connect_error());
        }

        $this->client = $client;

        $this->use($config['base']);
    }

    /**
     * @param string $database
     */
    public function use(string $database): void
    {
        $this->query("USE `%s`;", $database);
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->client instanceof mysqli && $this->client->ping();
    }

    /**
     * @param string $query
     * @param string ...$args
     * @return mysqli_result
     * @throws DatabaseQueryException
     */
    public function query(string $query, ...$args): mysqli_result
    {
        $result = $this->client->query($this->format($query, ...$args));

        if ($result === true) {
            return new mysqli_result($this->client);
        }

        if (!$result instanceof mysqli_result) {
            throw new DatabaseQueryException($this->client->error);
        }

        return $result;
    }

    /**
     * @param string $query
     * @param string ...$args
     * @return mixed
     */
    public function execute(string $query, ...$args)
    {
        return $this->query($query, ...$args)->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param array $config
     * @throws DatabaseConfigException
     */
    protected function checkConfig(array $config): void
    {
        if (!isset($config['host']) || empty($config['host'])) {
            throw new DatabaseConfigException("Invalid config parameter 'host': can't be empty");
        }

        if (!isset($config['user']) || empty($config['user'])) {
            throw new DatabaseConfigException("Invalid config parameter 'user': can't be empty");
        }

        if (!isset($config['pass']) || empty($config['pass'])) {
            throw new DatabaseConfigException("Invalid config parameter 'pass': can't be empty");
        }

        if (!isset($config['base']) || empty($config['base'])) {
            throw new DatabaseConfigException("Invalid config parameter 'base': can't be empty");
        }
    }

    public function disconnect(): void
    {
        $this->client->close();
    }

    public function format(string $query, ...$args): string
    {
        foreach ($args as &$arg) {
            $arg = $this->client->real_escape_string($arg);
        }
        return sprintf(
            $query,
            ...$args
        );
    }
}

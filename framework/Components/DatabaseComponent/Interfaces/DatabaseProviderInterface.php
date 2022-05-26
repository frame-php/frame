<?php

namespace Framework\Components\DatabaseComponent\Interfaces;

interface DatabaseProviderInterface
{
    public function name(): string;
    public function connect(array $config): void;
    public function disconnect(): void;
    public function isConnected(): bool;
    public function execute(string $query, ...$args);
}
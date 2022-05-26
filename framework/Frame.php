<?php

namespace Framework;

use Exception;
use Framework\Components\ConfigComponent\Config;
use Framework\Components\DatabaseComponent\Database;
use Framework\Handlers\Interfaces\FrameHandlerInterface;

class Frame
{
    public const VERSION = '0.1.1';

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @var FrameHandlerInterface
     */
    private $handler;

    /**
     * @var array
     */
    private $provider;

    /**
     * Frame constructor.
     * @param FrameHandlerInterface $handler
     * @param array $provider
     * @throws Exception
     */
    public function __construct(
        FrameHandlerInterface $handler,
        array $provider = []
    ) {
        self::checkDuplicate();
        $this->handler = $handler;
        $this->provider = $provider;
    }

    public function __destruct()
    {
        Database::close();
    }

    /**
     * @throws Exception
     */
    public function __clone()
    {
        self::checkDuplicate();
    }

    /**
     * @param FrameHandlerInterface|null $handler
     * @param array $provider
     * @return self
     */
    public static function frame(
        ?FrameHandlerInterface $handler = null,
        array $provider = []
    ): self {
        if (self::$instance === null) {
            (self::$instance = new self(
                $handler,
                $provider
            ))->run();
        }

        return self::$instance;
    }

    /**
     * @throws Exception
     */
    private static function checkDuplicate(): void
    {
        if (self::$instance instanceof self) {
            throw new Exception('Application is already running!');
        }
    }

    /**
     * @return $this
     */
    private function run(): self
    {
        foreach (FRAME_CONFIGS as $name) {
            Config::load($name);
        }

        $this->debug(Config::get('main.debug', false));

        $connection_key = Config::get('database.default', 'default');
        $connection = Config::get("database.connections.{$connection_key}", []);
        $connection_provider = $connection['provider'] ?? null;
        $connection_config = $connection['config'] ?? [];

        Database::init($connection_provider, $connection_config);

        $this->handler->process();
        return $this;
    }

    /**
     * @param string $name
     * @param array $args
     * @param null $default
     * @return mixed|null
     */
    public function make(string $name, array $args = [], $default = null)
    {
        if (isset($this->provider[$name])) {
            if (is_string($this->provider[$name]) && class_exists($this->provider[$name], false)) {
                return new $this->provider[$name](...$args);
            }

            return $this->provider[$name];
        }

        if (is_string($name) && class_exists($name, false)) {
            return new $name(...$args);
        }

        return $default;
    }

    /**
     * @return float microtime seconds
     */
    public function uptime(): float
    {
        return microtime(true) - FRAME_START;
    }

    public function debug(bool $enabled): void
    {
        ini_set('display_errors', $enabled);
    }
}

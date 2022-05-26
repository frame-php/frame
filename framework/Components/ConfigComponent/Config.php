<?php

namespace Framework\Components\ConfigComponent;

class Config
{
    protected static $configs = [];

    public static function get(string $name, $default = null)
    {
        $path = explode('.', $name);
        $config = array_shift($path);
        $data = self::load($config);
        foreach ($path as $item) {
            $data = $data[$item] ?? null;
        }
        return $data ?? $default;
    }

    public static function load(string $name): array
    {
        return self::$configs[$name] ?? (self::$configs[$name] =
                array_replace_recursive(
                    self::read($name),
                    self::read("{$name}.env")
                )
            );
    }

    protected static function read(string $name): array
    {
        $filename = CONFIG_DIR . DIRECTORY_SEPARATOR . "{$name}.php";
        if (file_exists($filename)) {
            $config = require $filename;
            if (is_array($config)) {
                return $config;
            }
        }
        return [];
    }
}

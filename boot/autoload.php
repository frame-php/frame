<?php

const CLASS_SEPARATOR = '\\';

const AUTOLOAD_MAP = [
    'App' . CLASS_SEPARATOR => 'app' . DIRECTORY_SEPARATOR,
    'Framework' . CLASS_SEPARATOR => 'framework' . DIRECTORY_SEPARATOR,
];

function classNameToFilePath($class)
{
    foreach (AUTOLOAD_MAP as $namespace => $path) {
        $class = str_replace($namespace, $path, $class);
    }
    return str_replace(CLASS_SEPARATOR, DIRECTORY_SEPARATOR, ROOT_DIR . DIRECTORY_SEPARATOR . "{$class}.php");
}

spl_autoload_register(static function ($class) {
    $path = classNameToFilePath($class);
    if (file_exists($path)) {
        include_once $path;
    } else {
        throw new Exception(
            sprintf(
                'Class with name %1$s not found. Looked in %2$s.',
                $class,
                $path
            )
        );
    }
});

<?php

if (!function_exists('frame')) {
    function frame(): \Framework\Frame
    {
        return \Framework\Frame::frame();
    }
}

if (!function_exists('request')) {
    function request(): \Framework\Entities\Request
    {
        return new \Framework\Entities\Request();
    }
}

if (!function_exists('response')) {
    function response(): \Framework\Entities\Response
    {
        return new \Framework\Entities\Response();
    }
}

if (!function_exists('db')) {
    function db(): \Framework\Components\DatabaseComponent\DatabaseManager
    {
        return \Framework\Components\DatabaseComponent\Database::manager();
    }
}

if (!function_exists('array_is_list')) {

    function array_is_list(array $array): bool
    {
        $expected = 0;
        foreach ($array as $i => $_) {
            if ($i !== $expected) return false;
            $expected++;
        }
        return true;
    }
}
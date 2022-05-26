<?php

namespace Framework\Factories;

use Framework\Entities\Request;

class RequestFactory
{
    public static function make(): Request
    {
        return new Request();
    }
}

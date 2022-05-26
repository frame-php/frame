<?php

namespace Framework\Factories;

use Framework\Entities\Response;

class ResponseFactory
{
    public static function make(): Response
    {
        return new Response();
    }
}

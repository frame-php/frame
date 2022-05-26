<?php

namespace Framework\Handlers;

use Framework\Components\ConfigComponent\Config;
use Framework\Components\RouterComponent\Router;
use Framework\Exceptions\CommandExceptions\CommandException;
use Framework\Exceptions\CommandExceptions\NotFoundCommandClassException;
use Framework\Exceptions\CommandExceptions\NotFoundCommandException;
use Framework\Exceptions\CommandExceptions\NotFoundCommandMethodException;
use Framework\Factories\RequestFactory;
use Framework\Handlers\Interfaces\FrameHandlerInterface;
use Throwable;

class FrameCommandHandler implements FrameHandlerInterface
{
    /**
     * @throws NotFoundCommandException
     * @throws NotFoundCommandClassException
     * @throws NotFoundCommandMethodException
     * @throws CommandException
     */
    public function process(): void
    {
        $request = RequestFactory::make();
        $data = Router::determine(
            $request->line(),
            Config::get('commands'),
            null,
            null,
            'handle',
            '/^',
            '$/'
        );
        if ($data === null) {
            throw new NotFoundCommandException();
        }
        $class = $data[0] ?? null;
        $method = $data[1] ?? null;
        $args = $data[2] ?? [];
        if (!class_exists($class)) {
            throw new NotFoundCommandClassException("Invalid operation class '{$class}'!");
        }
        $operation = new $class();
        if (!method_exists($operation, $method)) {
            throw new NotFoundCommandMethodException("Invalid operation class '{$class}' method '{$method}'!");
        }
        try {
            $operation->{$method}(...$args);
        } catch (Throwable $ex) {
            throw new CommandException($ex->getMessage(), 0, $ex);
        }
    }
}

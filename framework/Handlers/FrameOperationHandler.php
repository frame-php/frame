<?php

namespace Framework\Handlers;

use Framework\Components\ConfigComponent\Config;
use Framework\Components\RouterComponent\Router;
use Framework\Entities\Response;
use Framework\Exceptions\OperationExceptions\NotFoundOperationClassException;
use Framework\Exceptions\OperationExceptions\NotFoundOperationException;
use Framework\Exceptions\OperationExceptions\NotFoundOperationMethodException;
use Framework\Exceptions\OperationExceptions\OperationException;
use Framework\Factories\RequestFactory;
use Framework\Handlers\Interfaces\FrameHandlerInterface;
use Throwable;

class FrameOperationHandler implements FrameHandlerInterface
{
    /**
     * @throws NotFoundOperationException
     * @throws NotFoundOperationClassException
     * @throws NotFoundOperationMethodException
     * @throws OperationException
     */
    public function process(): void
    {
        $request = RequestFactory::make();
        $data = Router::determine(
            $request->uri(),
            Config::get('operations'),
            null,
            null,
            'handle',
            '/^\/',
            '$/'
        );
        if ($data === null) {
            throw new NotFoundOperationException();
        }
        $class = $data[0] ?? null;
        $method = $data[1] ?? null;
        $args = $data[2] ?? [];
        if (!class_exists($class)) {
            throw new NotFoundOperationClassException("Invalid operation class '{$class}'!");
        }
        $operation = new $class();
        if (!method_exists($operation, $method)) {
            throw new NotFoundOperationMethodException("Invalid operation class '{$class}' method '{$method}'!");
        }
        try {
            $response = $operation->{$method}($request, ...$args);
            if ($response instanceof Response) {
                $response->render();
            }
        } catch (Throwable $ex) {
            throw new OperationException($ex->getMessage(), 0, $ex);
        }
    }
}

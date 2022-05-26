<?php

namespace Framework\Exceptions;

use RuntimeException;
use Throwable;

class FrameException extends RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @throws Throwable
     */
    public static function throw($message = '', $code = 0, Throwable $previous = null): void
    {
        throw new static($message, $code, $previous);
    }
}

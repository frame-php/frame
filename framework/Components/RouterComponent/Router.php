<?php

namespace Framework\Components\RouterComponent;

class Router
{
    public static function determine(
        ?string $input,
        array $list,
        $defaultIndex = null,
        ?array $defaultValue = null,
        ?string $defaultMethod = null,
        string $prefix = '/^',
        string $postfix = '$/',
        string $trim = '/'
    ): ?array {
        foreach ($list as $pattern => $item) {
            if ($pattern != $defaultIndex) {
                $match = preg_match(
                    $prefix . trim($pattern, $trim) . $postfix,
                    $input,
                    $args
                );
                if ($match) {
                    $args = array_filter($args, "is_string", ARRAY_FILTER_USE_KEY);
                    return self::compose($item, $args, $defaultMethod);
                }
            }
        }
        return isset($list[$defaultIndex])
            ? self::compose($list[$defaultIndex], [], $defaultMethod)
            : $defaultValue;
    }

    protected static function compose($item, $args, ?string $defaultMethod = null): array
    {
        return [$item[0] ?? null, $item[1] ?? $defaultMethod, array_values($args ?? [])];
    }
}

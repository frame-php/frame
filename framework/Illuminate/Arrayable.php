<?php

namespace Framework\Illuminate;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @link https://github.com/illuminate <3 thx
 */
interface Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray();
}

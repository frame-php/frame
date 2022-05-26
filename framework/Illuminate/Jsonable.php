<?php

namespace Framework\Illuminate;

/**
 * Interface Jsonable
 * @package Framework\Illuminate
 *
 * @link https://github.com/illuminate <3 thx
 */
interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);
}

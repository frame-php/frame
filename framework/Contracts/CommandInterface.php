<?php

namespace Framework\Contracts;

interface CommandInterface
{
    public function handle(): void;
}

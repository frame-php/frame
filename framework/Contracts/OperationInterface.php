<?php

namespace Framework\Contracts;

use Framework\Entities\Request;
use Framework\Entities\Response;

interface OperationInterface
{
    public function handle(Request $request): Response;
}

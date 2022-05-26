<?php

namespace App\Operations;

use Framework\Components\DatabaseComponent\Database;
use Framework\Contracts\OperationInterface;
use Framework\Entities\Request;
use Framework\Entities\Response;
use Framework\Frame;

class ExampleOperation implements OperationInterface
{
    public function handle(Request $request): Response
    {
        db()->connectIfNeed();
        return response()->view('example', [
            'frame' => frame(),
            'request' => $request,
            'title' => 'Frame Example',
            'version' => 'Frame Example Version: ' . Frame::VERSION,
            'page' => $request->uri(),
            'get' => $request->get(),
            'post' => $request->post(),
            'all' => $request->all(),
        ]);
    }

    public function page200(Request $request, $id = 'EMPTY'): Response
    {
        return \response()->html("ID: {$id}", 200);
    }

    public function page404(Request $request, $id = 'EMPTY'): Response
    {
        return \response()->html("ID: {$id}", 404);
    }
}

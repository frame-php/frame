<?php

use Framework\Entities\Request;
use Framework\Frame;

/**
 * @var Frame $frame
 * @var Request $request
 * @var string $title
 * @var string $version
 * @var string $page
 * @var array $get
 * @var array $post
 * @var array $all
 */
?>

<html lang="EN">
<head>
    <title>
        <?= $title ?>
    </title>
</head>
<body style="text-align: center; padding-top: 15%">
    <?= $version ?>
    <br/>
    <input readonly value="<?= $page ?>"/>
    <?php if ($get): ?>
        <h3>GET JSON</h3>
        <textarea>
    <?= json_encode($get) ?>
    </textarea>
    <?php endif; ?>
    <?php if ($request->isPost()): ?>
        <h3>POST JSON</h3>
        <textarea>
    <?= json_encode($post) ?>
    </textarea>
    <?php endif; ?>
    <h3>TIME</h3>
    <input readonly value="<?= $frame->uptime() ?> seconds"/>
    <h3>DATABASE</h3>
    <input readonly value="Provider: <?= db()->name() ?>"/>
    <br/>
    <input readonly value="Status: <?= db()->isConnected() ? 'SUCCESS' : 'FAIL' ?>"/>
    <br/>
    <br/>
    <button onclick="alert('U2FsdGVkX18YZrTc1vbTCU4u54AHr7h0xlYpBeXr+pGez4aNtJIL8Zl/dncMec3tnQuEdH+57la2rn/jsSnZVw==')">
        yr 2022 by IT
    </button>
    <br/>
</body>
</html>
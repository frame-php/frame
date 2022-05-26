<?php

error_reporting(E_ALL);

const FRAME_CONFIGS = [
    'main',
    'database',
    'operations',
    'commands',
];

require_once FRAMEWORK_DIR . DIRECTORY_SEPARATOR . 'Frame.php';

require_once BOOT_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

require_once BOOT_DIR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'frame.php';

require_once BOOT_DIR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'illuminate.php';

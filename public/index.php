<?php

define('FRAME_START', microtime(true));

const FR_MODE_COMMAND = 'command';
const FR_MODE_OPERATION = 'operation';

const FR_MODE = FR_MODE_OPERATION;

const PUBLIC_DIR = __DIR__;

const ROOT_DIR = PUBLIC_DIR . DIRECTORY_SEPARATOR . '..';

const APP_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'app';

const BOOT_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'boot';
const BOOT_CACHE_DIR = BOOT_DIR . DIRECTORY_SEPARATOR . 'cache';

const CONFIG_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'config';
const FRAMEWORK_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'framework';
const VIEW_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'views';

require_once BOOT_DIR . DIRECTORY_SEPARATOR . 'bootstrap.php';

\Framework\Frame::frame(
    new \Framework\Handlers\FrameOperationHandler(),
    require BOOT_DIR . DIRECTORY_SEPARATOR . 'provider.php'
);

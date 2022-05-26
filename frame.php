<?php

define('FRAME_START', microtime(true));

const FR_MODE_COMMAND = 'command';
const FR_MODE_OPERATION = 'operation';

const FR_MODE = FR_MODE_COMMAND;

const ROOT_DIR = __DIR__;

const PUBLIC_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'public';

const APP_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'app';

const BOOT_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'boot';
const BOOT_CACHE_DIR = BOOT_DIR . DIRECTORY_SEPARATOR . 'cache';

const CONFIG_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'config';
const FRAMEWORK_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'framework';
const VIEW_DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'views';

require_once BOOT_DIR . DIRECTORY_SEPARATOR . 'bootstrap.php';

\Framework\Frame::frame(
    new \Framework\Handlers\FrameCommandHandler(),
    require BOOT_DIR . DIRECTORY_SEPARATOR . 'provider.php'
);

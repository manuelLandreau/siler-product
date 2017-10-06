<?php

// Static files
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Siler\Dotenv\init(__DIR__ . '/../');

require_once __DIR__ . '/container.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/paginator.php';
require_once __DIR__ . '/twig.php';

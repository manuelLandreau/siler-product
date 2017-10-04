<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Siler\Dotenv\init(__DIR__ . '/../');

require_once __DIR__ . '/container.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/paginator.php';
require_once __DIR__ . '/twig.php';

<?php

(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';
use \PhproSmartCrud\Console\Application;

$application = new Application();
$application->run();

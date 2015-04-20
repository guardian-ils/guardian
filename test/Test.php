<?php
/**
 * Guardian Test
 */

use \Composer\Autoload\ClassLoader;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

$src = dirname(__DIR__) . '/src';
$test = dirname(__DIR__) . '/test';

$srcLoader = new ClassLoader();
$srcLoader->setPsr4('Guardian\\', array($src));
$srcLoader->setPsr4('Guardian\\Test\\', $test);
$srcLoader->register();
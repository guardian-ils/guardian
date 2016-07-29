<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

$loader = require __DIR__.'/../vendor/autoload.php';
if (getenv('APP_ENV') !== 'testing') {
    $cacheLoader = null;
    if (function_exists('apcu_fetch')) {
        $cacheLoader = new \Symfony\Component\ClassLoader\ApcClassLoader('guardian', $loader);
    } elseif (extension_loaded('xcache')) {
        $cacheLoader = new \Symfony\Component\ClassLoader\XcacheClassLoader('guardian', $loader);
    } elseif (extension_loaded('wincache')) {
        $cacheLoader = new \Symfony\Component\ClassLoader\WinCacheClassLoader('guardian', $loader);
    }
    if ($cacheLoader !== null)
        $cacheLoader->register(true);
}

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}

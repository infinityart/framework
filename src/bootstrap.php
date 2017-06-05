<?php
/**
 * User: Jonty
 * Date: 6/5/2017
 */

namespace Framework;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Registers The error handler
 */
error_reporting(E_ALL);

$env = 'development';
$whoops = new Run;

if ($env !== 'production') {
    $whoops->pushHandler(new PrettyPageHandler());
} else {
    $whoops->pushHandler(function($e){
        echo 'Todo: Friendly error page and log it.';
    });
}
$whoops->register();
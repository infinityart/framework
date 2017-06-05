<?php
/**
 * User: Jonty
 * Date: 6/5/2017
 */

namespace Framework;

use Http\HttpRequest;
use Http\HttpResponse;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Registers The error handler.
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

/**
 * Register http component.
 */
$request = new HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new HttpResponse();

foreach ($response->getHeaders() as $header) {
    header($header, false);
}

echo $response->getContent();
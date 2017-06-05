<?php
/**
 * User: Jonty
 * Date: 6/5/2017
 */

namespace Framework;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
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


/**
 * Register router
 */
$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $routes = include 'routes.php';
    foreach ($routes as $route){
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler, $vars);
        break;
}

/*
 * Showing http component headers
 */
foreach ($response->getHeaders() as $header) {
    header($header, false);
}

echo $response->getContent();
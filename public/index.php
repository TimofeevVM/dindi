<?php

require __DIR__ . '/../vendor/autoload.php';

$configDi = require __DIR__ . '/../config/di.php';
$container = (new \Shared\Infrastructure\PhpDI\PhpDIFactory())->create($configDi);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        echo 'home';
    });
    $r->addRoute('POST', '/post', [\Blog\Infrastructure\Http\PostController::class, 'createPost']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        if (is_callable($handler)) {
            $handler();
            break;
        }

        $container->call($handler);
        break;
}

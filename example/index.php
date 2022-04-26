<?php

namespace Example;

use Ask\Factory;

$micro_time = microtime(true);

require __DIR__ . '/../autoload.php';

$app = new Factory($micro_time, __DIR__, 'ru');
$app->run(
    error: array(404 => Error::class),
    route: array(
        '/' => array(route\index\Index::class), 'index',
        '/page/{path:page}' => array(route\page\Page::class), 'page',
        '/response/{response}' => array(route\response\Response::class), 'response',
    ),
);
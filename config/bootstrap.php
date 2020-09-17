<?php

use DI\ContainerBuilder;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/version.php');
// require_once(__DIR__ . '/session.php');
// require_once(__DIR__ . '/config/game.php');

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);
date_default_timezone_set($container->get('settings')['app']['timezone']);

(require __DIR__ . '/middleware.php')($app);
(require __DIR__ . '/routes.php')($app);

return $app;
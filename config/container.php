<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use DI\Container;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\UriFactory;

use function DI\autowire;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigMiddleware;
use Slim\Views\TwigRuntimeLoader;

use ParagonIE\EasyDB\EasyDB;
use ParagonIE\EasyDB\Factory;

return [
  //Settings
  'settings' => function () {
    return require __DIR__ . '/settings.php';
  },

  // //App
  App::class => function (ContainerInterface $container) {
    AppFactory::setContainer($container);
    $app = AppFactory::create();
    return $app;
  },

  // //Response
  ResponseFactoryInterface::class => function (ContainerInterface $container) {
    return $container->get(App::class)->getResponseFactory();
  },

  // //Route parser
  RouteParserInterface::class => function (ContainerInterface $container) {
    return $container->get(App::class)->getRouteCollector()->getRouteParser();
  },

  // //Twig middleware
  TwigMiddleware::class => function (ContainerInterface $container) {
    return TwigMiddleware::createFromContainer($container->get(App::class), Twig::class);
  },

  // Twig templates
  Twig::class => function (ContainerInterface $container){
    $config = (array)$container->get('settings');
    $settings = $config['twig'];
    $options = $settings['options'];
    $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;

    $twig = Twig::create($settings['paths'], $options);

    $loader = $twig->getLoader();
    $publicPath = (string)$config['public'];
    if ($loader instanceof FilesystemLoader) {
        $loader->addPath($publicPath, 'public');
    }

    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $twig->getEnvironment()->addGlobal('app', $config['app']);
    $twig->getEnvironment()->addGlobal('modules', $config['modules']);

    return $twig;

  },
  
  'view' => static function(Container $container){
    return $container->get(Twig::class);
  },

  EasyDB::class => function (ContainerInterface $container){
    $config = (array) $container->get('settings')['database'];
    try{
      $db = \ParagonIE\EasyDB\Factory::fromArray([
        $config['dsn'] = $config['method'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'],
        $config['username'],
        $config['password'],
        $config['flags']
      ]);
    } catch (Exception $e){
      return false;
    }
    $db->prefix = $config['prefix'];
    return $db;
  },

];
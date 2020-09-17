<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app){
  $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');
  $app->get('/rounds', \App\Action\Rounds\RoundIndexAction::class)->setName('rounds.index');
};

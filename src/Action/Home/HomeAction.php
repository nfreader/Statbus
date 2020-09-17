<?php

namespace App\Action\Home;

use App\Action\ActionHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

final class HomeAction extends ActionHandler
{

  protected $template = 'home/home.twig';

  public function __construct(Twig $twig) {
    $this->twig = $twig;
  }

  public function action(): Response {
    return $this->respond();
  }

}
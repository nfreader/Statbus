<?php

namespace App\Action\Rounds\RoundAction;

use App\Action\ActionHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use App\Domain\Rounds\Repository\GetRoundListing as Repository;

final class RoundAction extends ActionHandler
{

  protected $template = 'home/home.twig';

  public function __construct(Twig $twig, Repository $repo) {
    parent::__construct($twig);
    $this->repo = $repo;
  }

  public function action(): Response {
    return $this->respond($this->repo->action());
  }

}
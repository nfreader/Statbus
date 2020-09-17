<?php

namespace App\Action\Rounds;

use App\Action\ActionHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

use App\Domain\Rounds\Services\GetRoundListing as Rounds;

final class RoundIndexAction extends ActionHandler
{

  protected $template = 'rounds/index.twig';

  protected $twig;

  protected $rounds;

  public function __construct(Twig $twig, Rounds $rounds) {
    parent::__construct($twig);
    $this->rounds = $rounds;
  }

  public function action(): Response {
    return $this->respond(['rounds' => $this->rounds->index()]);
  }

}
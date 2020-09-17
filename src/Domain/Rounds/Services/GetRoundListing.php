<?php

namespace App\Domain\Rounds\Services;

use App\Domain\Rounds\Repository\SelectRounds as Repo;

class GetRoundListing
{

  protected $repo;

  public function __construct(Repo $repo) {
    $this->repo = $repo;
  }

  public function index($page = 1) {
    return $this->repo->RoundListing($page);
  }

}
<?php
namespace App\Domain\Rounds\Repository;

use App\Domain\Rounds\Repository\RoundRepository as Repo;

use App\Domain\Rounds\Services\ParseRound;

class SelectRounds extends Repo
{

  public function RoundListing($page = 1) {
    $rounds = $this->DB->run($this->TablePrefix("SELECT $this->columns FROM $this->table ORDER BY id DESC LIMIT 0, 60"));
    $this->ParseRound = new ParseRound();
    foreach ($rounds as &$round) {
      $round = $this->ParseRound->ParseRound($round);
    }
    return $rounds;
  }

}
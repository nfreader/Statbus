<?php
namespace App\Domain\Rounds\Repository;

use App\Domain\Rounds\Repository\RoundRepository as Repo;

class SelectRounds extends Repo
{

  public function RoundListing($page = 1) {
    return $this->DB->run($this->TablePrefix("SELECT $this->columns FROM $this->table ORDER BY id DESC LIMIT 0, 60"));
  }

}
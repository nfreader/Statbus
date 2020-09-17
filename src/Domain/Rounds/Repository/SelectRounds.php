<?php
namespace App\Domain\Rounds\Repository;

use App\Domain\Rounds\Repository\RoundRepository as Repo;

class SelectRounds extends Repo
{

  public function action($page = 1) {
    var_dump($this->DB->run("SELECT * FROM $this->table LIMIT 0, 1000"));
  }

}
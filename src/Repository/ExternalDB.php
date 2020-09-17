<?php

namespace App\Repository;

use ParagonIE\EasyDB\EasyDB as DB;

class ExternalDB
{

  public function __construct(DB $db){
    $this->DB = $db;
  }

  protected function TablePrefix($query){
    return str_replace('tbl_', $this->DB->prefix, $query);
  }

}
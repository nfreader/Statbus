<?php

namespace App\Repository;

use ParagonIE\EasyDB\EasyDB as DB;

class ExternalDB
{

  public function __construct(DB $db){
    $this->DB = $db;
  }

  protected function TablePrefix(){
    $this->columns = str_replace('tbl_',$this->DB->prefix, $this->columns);
    $this->table = str_replace('tbl_',$this->DB->prefix, $this->table);
  }

}
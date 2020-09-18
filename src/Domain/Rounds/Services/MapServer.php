<?php
namespace App\Domain\Rounds\Services;

class MapServer
{

  protected $servers;

  public function __construct(){
    $this->servers = $this->getServerJson();
  }

  private function getServerJson(){
    return json_decode(file_get_contents(__DIR__.'/../../../../resources/data/servers.json'));
  }

  public function getServer($port){
    return (object) $this->servers[array_search($port, array_column($this->servers, 'port'))];
  }

}
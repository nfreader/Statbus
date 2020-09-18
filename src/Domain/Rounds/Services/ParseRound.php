<?php

namespace App\Domain\Rounds\Services;

use App\Domain\Rounds\Data\Round;
use App\Domain\Rounds\Services\MapServer;

class ParseRound
{

  private $MapServer;

  public function __construct(){
    $this->MapServer = new MapServer();
  }

  public function ParseRound($data): Round {
    $round = new Round;
    $round->icons = new \stdclass;
    foreach($data as $k => $v){
      $round->$k = $v;
    }
    if('undefined' === $round->result || !$round->result) {
      $round->result = $round->end_state;
    }
    $round = $this->RoundEndResult($round);
    $round->server = $this->MapServer->getServer($round->port);
    $round->logs = FALSE; //No logs by default
    if(isset($round->server->public_logs)){
      $round->logs = TRUE;
      $date = new \DateTime($round->init);
      $year = $date->format('Y');
      $month = $date->format('m');
      $day = $date->format('d');
      $round->remote_logs = $round->server->public_logs;
      $round->remote_logs.= "$year/$month/$day/round-$round->id.zip";
      $round->remote_logs_dir = str_replace('.zip', '', $round->remote_logs);
      $round->admin_logs_dir = str_replace($round->server->public_logs, $round->server->raw_logs, $round->remote_logs_dir);
    }
    return $round;
  }

  private function RoundEndResult($round){
    if(strpos($round->result, 'win - ') !== FALSE){
      $round->class = 'success';
      $round->icons->result = 'medal';
    } else if (strpos($round->result, 'loss - ') !== FALSE) {
      $round->class = 'danger';
      $round->icons->result = 'times';
    } else if (strpos($round->result, 'halfwin - ') !== FALSE) {
      $round->class = 'warning';
      $round->icons->result = 'minus';
    } else if (strpos($round->result, 'admin reboot - ') !== FALSE) {
      $round->class = 'reboot';
      $round->icons->result = 'redo';
    } else if ('restart vote' === $round->result) {
      $round->class = 'vote';
      $round->icons->result = 'vote-yea';
    } else {
      $round->class = 'proper';
      $round->icons->result = 'check';
    }
    if ('nuke' === $round->end_state) {
      $round->class = 'inverse';
      $round->icons->result = 'bomb';
    }
    return $round;
  }

}
<?php

namespace App\Domain\Rounds\Repository;

use ParagonIE\EasyDB\EasyDB as DB;
use App\Repository\ExternalDB;

class RoundRepository extends ExternalDB
{

  protected $db;

  protected $table = 'tbl_round';

  protected $columns = 'tbl_round.id,
  tbl_round.initialize_datetime as init,
  tbl_round.start_datetime as start,
  tbl_round.shutdown_datetime as shutdown,
  tbl_round.end_datetime as end,
  tbl_round.server_port AS port,
  tbl_round.commit_hash,
  tbl_round.game_mode AS mode,
  tbl_round.game_mode_result AS result,
  tbl_round.end_state,
  tbl_round.shuttle_name AS shuttle,
  tbl_round.map_name AS map,
  tbl_round.station_name as name,
  SEC_TO_TIME(TIMESTAMPDIFF(SECOND, tbl_round.initialize_datetime, tbl_round.shutdown_datetime)) AS duration,
  SEC_TO_TIME(TIMESTAMPDIFF(SECOND, tbl_round.start_datetime, tbl_round.end_datetime)) AS round_duration,
  SEC_TO_TIME(TIMESTAMPDIFF(SECOND, tbl_round.initialize_datetime, tbl_round.start_datetime)) AS init_time,
  SEC_TO_TIME(TIMESTAMPDIFF(SECOND, tbl_round.end_datetime, tbl_round.shutdown_datetime)) AS shutdown_time';

  public function __construct(DB $db){
    parent::__construct($db);
  }

}
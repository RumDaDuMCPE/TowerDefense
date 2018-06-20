<?php

namespace TowerDefense\api\game;

use TowerDefense\api\game\managers\TeamManager;

class Game {

  private $id;
  private $teammanager;
  private $time;
  
  public function __construct(int $id, TeamManager $teams) {
    $this->id = $id;
    $this->teammanager = $teams;
    $this->time = 0;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getTeamManager() {
    return $this->teammanager;
  }
  
  public function getTime() {
    return $this->time;
  }
  
  public function updateTime() {
    $this->time++;
    //TODO: Rewrite this to update other parts of the game
  }
}

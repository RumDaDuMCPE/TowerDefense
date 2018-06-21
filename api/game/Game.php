<?php

namespace TowerDefense\api\game;

use TowerDefense\api\game\managers\TeamManager;

class Game {

  private $id;
  private $teammanager;
  private $time;
  private $map;
  private $player_count = 0;
  private $max_players;
  
  public function __construct(int $id, TeamManager $teams, string $map, int $max_players) {
    $this->id = $id;
    $this->teammanager = $teams;
    $this->time = 0;
    $this->map = $map;
    $this->max_players = $max_players;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getTeamManager() {
    return $this->teammanager;
  }
  
  public function getMap() {
    return $this->map;
  }
  
  public function getMaxPlayers() {
    return $this->max_players;
  }
  
  public function getPlayerCount() {
    return $this->player_count;
  }
  
  public function bumpPlayerCount() {
    $this->player_count++;
  }
  
  public function getTime() {
    return $this->time;
  }
  
  public function updateTime() {
    $this->time++;
    //TODO: Rewrite this to update other parts of the game
  }
}

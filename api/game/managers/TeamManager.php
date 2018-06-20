<?php

namespace TowerDefense\api\game\managers;

use TowerDefense\api\game\entities\Team;

class TeamManager {

  private $id;
  private $teams = [];
  
  public const RED = 0;
  public const GREEN = 1;
  public const BLUE = 2;
  public const YELLOW = 3;
  
  public function __construct(int $id) {
    $this->id = $id;
  }
  
  public function getTeam(int $team) {
    return $this->teams[$team] ? $this->teams[$team] : null;
  }
  
  public function getTeams() {
    return $this->teams;
  }
  
  public function addTeam(int $team_color, array $members): Team {
    $team = new Team($team_color, $members);
    $this->teams[$team_color] = $team;
    return $team;
  }
  
  public function removeTeam(int $team_color) {
    unset($this->teams[$team_color]);
  }
}

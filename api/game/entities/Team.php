<?php

namespace TowerDefense\api\game\entities;

use TowerDefense\api\Utils;
use pocketmine\Player;

class Team {
  
  private $team_color;
  private $members = [];
  private $points;
  
  public function __construct(int $team_color, array $members = []) {
    $this->team_color = $team_color;
    $this->members = $members;
    $this->points = 0;
  }
  
  public function getTeamColor() {
    return $this->team_color;
  }
  
  public function getMembers() {
    return $this->members;
  }
  
  public function getMember(Player $player) {
    return isset($this->members[strtolower($player->getName())]) ? $this->members[strtolower($player->getName())] : null;
  }
  
  public function addMember(Player $player) {
    $this->members[strtolower($player->getName())] = $player;
  }
  
  public function removeMember(Player $player) {
    unset($this->members[strtolower($player->getName())]);
  }
  
  public function getPoints() {
    return $this->points;
  }
  
  public function updatePoints(int $amount, int $data) {
    if($data === Utils::SET) {
      $this->points = $amount;
    } elseif($data === Utils::ADD) {
      $this->points += $amount;
    } elseif($data === Utils::TAKE) {
      $this->points -= $amount;
    } else {
      throw new \InvalidStateException("Invalid data has been set!");
    }
  }
}

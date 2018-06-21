<?php

namespace TowerDefense\api\player;

use TowerDefense\api\Utils;

class RBCPlayer {

  private $name;
  private $in_game = false;
  private $wins;
  
  public function __construct(string $name, int $wins) {
    $this->name = $name;
    $this->wins = $wins;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function isPlaying() {
    return $this->in_game;
  }
  
  public function setPlaying(bool $playing) {
    $this->in_game = $playing;
  }
  
  public function getWins() {
    return $this->wins;
  }
  
  public function updateWins(int $amount, int $data) {
    if($data === Utils::SET) {
      $this->wins = $amount;
    } elseif($data === Utils::ADD) {
      $this->wins += $amount;
    } elseif($data === Utils::TAKE) {
      $this->wins -= $amount;
    } else {
      throw new \InvalidStateException("Invalid data has been entered!");
    }
  }
}

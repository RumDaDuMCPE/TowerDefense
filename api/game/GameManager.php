<?php

namespace TowerDefense\api\game;

class GameManager {

  private static $instance;
  
  private $games = [];
  
  public function __construct() {
    self::$instance = $this;
  }
  
  public static function get() {
    return self::$instance;
  }
  
  public function getGame(int $id) {
    return isset($this->games[$id]) ? $this->games[$id] : null;
  }
  
  public function getGames() {
    return $this->games;
  }
  
  //This needs too be rewritten in the future too allow better game management
  public function createGame(): Game {
    $id = rand();
    $teams = new TeamManager($id);
    $game = new Game($id, $teams);
    $this->games[$id] = $game;
    return $game;
  }
  
  public function endGame(int $id) {
    $game = $this->getGame($id);
    foreach($game->getTeamManager()->getTeams() as $teams) {
      foreach($teams->getMembers() as $members) {
        //This checks if the players is still in the game or not
        if($members) {
          //TODO: Teleport players to the hub (I would prefer to do this when a proxy system is put in place to transfer players to diffrent hubs on the network!)
          $members->teleport();
        }
      }
    }
    unset($this->games[$id]);
  }
}

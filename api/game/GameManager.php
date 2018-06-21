<?php

namespace TowerDefense\api\game;

use TowerDefense\api\game\Game;
use TowerDefense\api\game\managers\TeamManager;

class GameManager {

  private static $instance;
  
  private $games = [];
  private $open = [];
  
  public function __construct() {
    self::$instance = $this;
  }
  
  public static function get() {
    return self::$instance;
  }
  
  public function getGame(string $id) {
    return isset($this->games[$id]) ? $this->games[$id] : null;
  }
  
  public function getIdByMap(string $map) {
    return $this->open[$map];
  }
  
  public function getGames() {
    return $this->games;
  }
  
  //This needs too be rewritten in the future too allow better game management
  public function createGame(string $map, int $maxplayers): Game {
    $id = rand();
    $this->open[$map] = $id;
    $teams = new TeamManager($id);
    $game = new Game($id, $teams, $map, $maxplayers);
    $this->games[$id] = $game;
    return $game;
  }
  
  public function addPlayerToGame(Player $player, string $gameId) {
    $data = PlayerManager::get()->getPlayer($player->getName());
    $game = $this->getGame($gameId);
    $game->bumpPlayerCount();
    $data->setPlaying(true, $gameId);
    $level = Loader::get()->getLevelByName($game->getMap());
    $player->teleport($level->getSafeSpawn());
    $this->chooseTeam($game, $player);
    if($game->getPlayerCount() === $game->getMaxPlayers()) {
      $this->prepare($gameId);
      unset($this->open[$gameId]);
      $this->createGame($game->getMap(), $game->getMaxPlayers());
    }
  }
  
  private function chooseTeam(Game $game, Player $player) {
     //TODO: Implement a system to allow players to choose a team
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
    //TODO: Reload the map
  }
}

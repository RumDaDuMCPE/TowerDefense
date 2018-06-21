<?php

namespace TowerDefense\api\player;

use TowerDefense\api\player\RBCPlayer;
use TowerDefense\Loader;
use pocketmine\utils\Config;


class PlayerManager {
  
  private static $instance;
  
  private $players = [];
  
  public function __construct() {
    self::$instance = $this;
  }
  
  public static function get() {
    return self::$instance;
  }
  
  public function getPlayer(string $name) {
    return isset($this->players[strtolower($name)]) ? $this->players[strtolower($name)] : null;
  }
  
  public function getPlayers() {
    return $this->players;
  }
  
  public function createPlayer(string $name) {
    $data = new RBCPlayer($name, 0);
    $this->players[strtolower($name)] = $data;
    return $data;
  }
  
  public function loadData() {
    $files = glob(Loader::get()->getDataFolder() . "users/*.json");
    $files = array_map(function($el) {
      return substr($el, strpos($el, Loader::get()->getDataFolder() . "users/")+6, -5);
    }, $files);
    foreach($files as $file) {
      $config = new Config(Loader::get()->getDataFolder() . "users/" . $file . ".json", Config;:JSON);
      $this->players[strtolower($file)] = new RBCPlayer($file, $config->get("wins"));
    }
  }
  
  public function saveData() {
    foreach($this->getPlayers() as $player) {
      $config = new Config(Loader::get()->getDataFolder() . "users/" . $player->getName() . ".json", Config::JSON);
      $config->set("wins", $player->getWins());
      $config->save();
    }
  }
}

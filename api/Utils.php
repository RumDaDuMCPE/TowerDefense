<?php

namespace TowerDefense\api;

use TowerDefense\Loader;
use TowerDefense\api\game\GameManager;
use TowerDefense\api\player\PlayerManager;

use pocketmine\Player;

class Utils {

  public const CHAT = 0;
  public const TITLE = 1;
  public const POP = 2;
  
  public const SET = 0;
  public const ADD = 1;
  public const TAKE = 2;
  
  public static function broadcast(string $message, Player $player, int $data, string $subtitle = "") {
    if (count($player) > 1) foreach($player as $players) {
      if($data === self::CHAT) {
        $players->sendMessage($message);
      } elseif($data === self::TITLE) {
        $players->addTitle($message, $subtitle, 20, 20, 20);
      } elseif($data === self::POP) {
        $players->sendPopup($message);
      } else {
        throw new \InvalidStateException("Invalid data entered!");
      }
    }
  }
  
  private static function loadClasses() {
    new GameManager();
    new PlayerManager();
  }
  
  public static function enable() {
    self::loadClasses();
    self::isFolder(Loader::get()->getDataFolder());
    self::isFolder(Loader::get()->getDataFolder() . "users");
    PlayerManager::get()->loadData();
  }
  
  public static function isFolder(string $folder) {
    if(!is_dir($folder)) {
      mkdir($folder);
    }
  }
  
  public static function disable() {
    PlayerManager::get()->saveData();
  }
}

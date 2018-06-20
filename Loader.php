<?php

namespace TowerDefense;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use TowerDefense\Events\{
    PlayerMovement,
    PlayerDamage,
    PlayerInteraction,
    PlayerDeath
}

class Loader extends PluginBase implements Listener {

    public $tasks = [];

    public $game1 = [];
    public $game2 = [];
    public $game3 = [];
    public $game4 = [];

    public $Team_A = [];
    public $Team_B = [];

  public function onEnable() {
      $this->registerEvents();

  }

  public function registerEvents() {
      foreach ([
          new PlayerMovement(),
          new PlayerInteraction(),
          new PlayerDamage(),
          new PlayerDeath()
               ] as $event) {
          $this->getServer()->getPluginManager()->registerEvents($event);
      }
  }

  public function findPlayerGame(string $player) : string {
      if (in_array($player, $this->game1)) {
          return "game1";
      }

      if (in_array($player, $this->game2)) {
          return "game2";
      }

      if (in_array($player, $this->game3)) {
          return "game3";
      }

      if (in_array($player, $this->game4)) {
          return "game4";
      }

  }

  public function sendPlayerToGame(string $player, int $coords) {
      if ($coords = /* game1 sign coords */ && count($this->game1) =< 16) {
          $this->game1[] = $player;
          $this->teleportPlayerToArena($player);

      }

  }

  public function isInAnyGame(string $player) {
      if (in_array($player, $this->game1) || in_array($player, $this->game2) || in_array($player, $this->game3) || in_array($player, $this->game4))
          return true;
  }

  public function isInGame(string $player) {
      if (isInAnyGame($player)) return true;
  }

  public function getOpponents(string $player) {
      if (in_array($player, $this->Team_A) && $this->isInTeamB($player)) {
          return true;
      } elseif (in_array($player, $this->Team_B) && $this->isInTeamA($player)) {
          return true;
      } else {
          return false;
      }
  }

  public function getAreas() {
      $areas = new Areas($this);
      $this->return($areas);
  }

  public function getEnemyBlock(string $player) {

  }

  public function isInTower(Player $player) {
      if ($this->getAreas()->isInTower($player)) return true;
  }

  public function unscheduleTask($id) {
      unset ($this->Tasks[$id]);
      Server::getInstance()->getScheduler()->cancelTask($id);
  }
}

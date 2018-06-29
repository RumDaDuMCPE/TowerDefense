<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
use TowerDefense\api\game\GameManager;
use TowerDefense\api\player\PlayerManager;
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerDeathEvent, PlayerInteractEvent, PlayerMoveEvent};
use pocketmine\nbt\tag\ByteTag;

class PlayerEvents implements Listener {
  
  private $seconds = 1;

  public function onPlayerInteract(PlayerInteractEvent $event) {
    $player = $event->getPlayer();
    $item = $event->getItem();
    $block = $event->getBlock();
    $data = PlayerManager::get()->getPlayer($player->getName());
    $tile = $block->getLevel()->getTile($block);
    if($block->getId() === 57) {
      $tick = 20;
      $time = $tick * $this->seconds;
      Loader::get()->getScheduler()->scheduleRepeatingTask(new Extraction(Loader::get(), $player), $time);
    }
    if($tile) {
      if($tile instanceof Sign) {
        if($tile->getLine(0) === "[TowerDefense]") {
          //TODO: Check if the map is valid
          $event->setCancelled(true);
          $game = GameManager::get()->getGame(GameManager::get()->getIdByMap($tile->getLine(1)))
          GameManager:;get()->addPlayerToGame($player, $tile->getLine(1));
        }
      }
    }
  }

  public function onPlayerMove(PlayerMoveEvent $event) {
    $player = $event->getPlayer();
    if(Loader::get()->isInGame($player)) {
      $name = $player->getName();
      if(Loader::get()->isInTower($player)) {
        Loader::get()->getScheduler()->scheduleRepeatingTask(new Warning(Loader::get(), $player), 5);
      }
    }
  }
}

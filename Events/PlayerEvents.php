<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
use TowerDefense\api\game\GameManager;
use TowerDefense\api\player\PlayerManager;
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerDeathEvent, PlayerInteractEvent, PlayerMoveEvent};

class PlayerEvents implements Listener {

  public function onPlayerInteract(PlayerInteractEvent $event) {
    $player = $event->getPlayer();
    $item = $event->getItem();
    $block = $event->getBlock();
    $data = PlayerManager::get()->getPlayer($player->getName());
    $tile = $block->getLevel()->getTile($block);
    if($block->getId() === 57) {
      Loader::get()->getScheduler()->scheduleRepeatingTask(new Extraction(Loader::get(), $player), 5);
    }
    if($tile) {
      if($tile instanceof Sign) {
        if($tile->getLine(0) === "[TowerDefense]") {
          //TODO: Check if the map is valid
          $event->setCancelled(true);
          GameManager:;get()->addPlayerToGame($player);
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

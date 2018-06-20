<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerDeathEvent, PlayerInteractEvent, PlayerMoveEvent};

class PlayerEvents implements Listener {

  public function onPlayerInteract(PlayerInteractEvent $event) {
    $player = $event->getPlayer();
    $item = $event->getItem();
    $block = $event->getBlock();
    if($block->getId() === 57) {
      Loader::get()->getScheduler()->scheduleRepeatingTask(new Extraction(Loader::get(), $player), 5);
     }
     if(Loader::get()->isNearSigns($player->getName())) {
      Loader::get()->sendPlayerToGame($player->getName());
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

  public function onPlayerDeath(PlayerDeathEvent $event) {
    $player = $event->getPlayer();
    if(Loader::get()->isInGame($player)) {
      $player->setGamemode(3);
      $player->getInventory()->clearAll();
      $player->getArmorInventory()->clearAll();
      $item = Item::get(Item::BED);
      $player->getInventory()->setItem(5, $item); // Adds back to lobby option.
    }
  }
}

<?php

namespace TowerDefense\Events;

use pocketmine\event\Listener;
use pocketmine\event\block\{BlockPlaceEvent, BlockBreakEvent, SignChangeEvent};
use TowerDefense\Loader;
use TowerDefense\api\player\PlayerManager;
use TowerDefense\api\game\GameManager;
use pocketmine\utils\TextFormat as c;

class BlockEvents implements Listener {

  public function onBlockPlace(BlockPlaceEvent $event) {
    $player = $event->getPlayer();
    $block = $event->getBlock();
    $item = $event->getItem();
    $data = PlayerManager::get()->getPlayer($player->getName());
    if(!$player->isOp()) {
      if(!$data->isPlaying()) {
        $event->setCancelled(true);
      } else {
        //TODO: Check if a player is placing blocks in a valid area
      }
    }
  }

  public function onSignChange(SignChangeEvent event) {
    $player = $event->getPlayer();
    $lines = $event->getLines();
    if($player->hasPermission("TowerDefense.sign.create")) {
      if($lines[0] === "[TowerDefense]" && isset($lines[1])) {
        //TODO: Check if there is a valid map
        $event->setLines(["[TowerDefense]", "TestMap", "2", ""]);
        GameManager::get()->createGame("TestMap", 2);
        $player->sendMessage(Loader::PREFIX . "A join sign has been created for TestMap!"); //Change the hardcode once maps have been implemented!
      } else {
        $event->setLines([c::RED . "[TowerDefense]", "You must put a map name!", "", ""]);
      }
    } else {
      $event->setCancelled(true);
    }
  }
  
  public function onBlockBreak(BlockBreakEvent $event) {
    $player = $event->getPlayer();
    $block = $event->getBlock();
    $item = $event->getItem();
    $data = PlayerManager::get()->getPlayer($player->getName());
    if(!$player->isOp()) {
      if(!$data->isPlaying()) {
        $event->setCancelled(true);
      } else {
        //TODO: Check if player is breaking blocks in a valid area!
      }
    }
  }
}

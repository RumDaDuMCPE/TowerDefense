<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
use TowerDefense\api\game\GameManager;
use TowerDefense\api\player\PlayerManager;
use pocketmine\event\Listener;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\Player;

class EntityEvents implements Listener {

  public function onEntityDamage(EntityDamageEvent $event) {
    $entity = $event->getEntity();
    $cause = $event->getCause();
    if($event instanceof EntityDamageByEntityEvent) {
      $damager = $event->getDamager();
      if($entity instanceof Player && $damager instanceof Player) {
        $entityData = PlayerManager::get()->getPlayer($entity->getName());
        $damagerData = PlayerManager::get()->getPlayer($damager->getName());
        if($entityData->isPlaying() && $damagerData->isPlaying()) {
          $game = GameManager::get()->getGame($damagerData->getGameId());
          if($game->getTeamManager()->getTeamByPlayer($entity) === $game->getTeamManager()->getTeamByPlayer($damager)) {
            $event->setCancelled(true);
          }
        }
      }
    }
  }
}

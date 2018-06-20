<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
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
        $event->setCancelled(true);
      }
    }
  }
}

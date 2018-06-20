<?php
/**
 * Created by PhpStorm.
 * User: Sahal
 * Date: 19/06/2018
 * Time: 19:47
 */

namespace TowerDefense\Events;

use pocketmine\{Player, Server};

use BaseFiles\BaseEvent;
use pocketmine\event\entity\EntityDamageEvent;

class PlayerDamage extends BaseEvent {
    public function onDamage(EntityDamageEvent $event) {
        if ($event instanceof EntityDamageByEntityEvent) {
            if ($event->getEntity() instanceof Player && $event->getDamager() instanceof Player) {
                $event->setCancelled();
            }
        }
    }
}
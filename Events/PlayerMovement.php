<?php
/**
 * User: Rum0
 * Date: 19/06/2018
 * Time: 18:09
 */

namespace TowerDefense\Events;

use pocketmine\event\player\PlayerMoveEvent;

use TowerDefense\Tasks\Warning;
use TowerDefense\Loader;

class PlayerMovement extends BaseEvent {
    public function onMove(PlayerMoveEvent $event) {
        if (Loader::getInstance()->isInGame($player = $event->getPlayer())) {
            $name = $player->getName();
            if ($this->getPlugin()->isInTower($player)) {
                $this->getServer()->getScheduler()->scheduleDelayedTask(new Warning($this->getPlugin(), $player));
            }
        }
    }
}
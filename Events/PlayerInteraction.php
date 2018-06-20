<?php
/**
 * Created by PhpStorm.
 * User: Sahal
 * Date: 19/06/2018
 * Time: 20:00
 */

namespace TowerDefense\Events;

use TowerDefense\Tasks\Extraction;
use TowerDefense\Loader;

use pocketmine\{Player, Server};
use pocketmine\event\player\PlayerInteractEvent;

class PlayerInteraction extends BaseEvent {
    public function onInteract(PlayerInteractEvent $event) {

        // EXTRACTION

        if ($event->getBlock()->getId() === 57) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new Extraction(Loader::getInstace, $event->getplayer()));
        }

        // JOIN

        $coords = $event->getBlock()->getPosition();
        if (Loader::getInstance()->isNearSigns($player->getName())) {
            Loader::getInstance()->sendPlayerToGame($player->getName());
        }
    }
}
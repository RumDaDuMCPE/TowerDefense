<?php
/**
 * Created by PhpStorm.
 * User: Sahal
 * Date: 19/06/2018
 * Time: 21:30
 */

namespace TowerDefense\Events;

use pocketmine\{Player, Server};
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Item;

use TowerDefense\BaseFiles\BaseEvent;
use TowerDefense\Loader;

class PlayerDeath extends BaseEvent {
    public function onDeath(PlayerDeathEvent $event) {
        if (Loader::getInstance()->isInGame($player)) {
            $player->setGamemode(3);
            $player->getInventory()->clearAll();
            $player->getInventory()->setItem(5, $item);
        }
    }
}
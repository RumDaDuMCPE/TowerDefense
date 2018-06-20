<?php
/**
 * Warns player if an opponent enters the tower.
 */

namespace TowerDefense\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as c;

use TowerDefense\Loader;

class Warning extends Task {
    public function __construct(Loader $loader, Player $player){
        parent::__construct($loader);
        $this->loader = $loader;
        $this->player = $player;
    }

    public function onRun($tick) {
        $msg = $this->loader->getMessages("breach", $this->player); // fetch the error message.
        $opponents = $this->loader->getOpponents($this->player->getName());
        $opponents->sendPopup($msg);
    }
}

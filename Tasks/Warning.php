<?php
/**
 * Created by PhpStorm.
 * User: Sahal
 * Date: 19/06/2018
 * Time: 18:33
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
        $msg = $this->loader->getMessage("breach", $this->player);
        $opponents = $this->loader->getOpponents($this->player->getName());
        $opponents->sendPopup($msg);
    }
}

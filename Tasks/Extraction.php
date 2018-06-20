<?php
/**
 * Created by PhpStorm.
 * User: Sahal
 * Date: 19/06/2018
 * Time: 20:33
 */

namespace TowerDefense\Tasks;

use pocketmine\scheduler\Task;
use pocketmine\Player;

use TowerDefense\Loader;

class Extraction extends Task {

    public $seconds = 0;

    public function __construct(Loader $loader, Player $player) {
        parent::__construct($loader);
        $this->player = $player;
        $this->loader = $loader;
    }

    public function onRun($tick) {
        if ($seconds = 10) {
            $msg = $this->loader->getMessage("Extraction.successful", $this->player);
            $this->player->sendMessage($msg);
            $block = $this->loader->getEnemyBlock($this->player->getName());
            $this->loader->unsetBlock($block)
        }
    }
}

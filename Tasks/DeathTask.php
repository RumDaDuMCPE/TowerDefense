<?php

namespace TowerDefense\Tasks;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\entity\Human;
use pocketmine\utils\TextFormat as c;
use pocketmine\scheduler\Task;

class DeathTask extends Task {

  private $time = 25;
  private $player;
  private $corpse;
  
  public function __construct(Player $player, Human $corpse) {
    $this->player = $player;
    $this->corpse = $corpse;
  }
  
  public function onRun(int $currentTick) {
    if($this->time <= 0) {
      $this->player->setGamemode(3);
      $this->player->getInventory()->clearAll();
      $this->player->getArmorInventory()->clearAll();
      $item = Item::get(Item::BED, 0 ,1)->setCustomName(c::RESET . c::BOLD. c::GOLD . "Return to lobby!");
      $this->player->getInventory()->setItem(4, $item);
      $this->corpse->close();
    } else $this->time--;
  }
}

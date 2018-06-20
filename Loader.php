<?php

namespace TowerDefense;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use TowerDefense\Events\{
    PlayerEvents,
    EntityEvents
}

class Loader extends PluginBase implements Listener {

    private static $instance;

    public $tasks = [];

    public function onEnable() {
        self::$instance = $this;
        $this->registerEvents();

    }

    public static function get() {
        return self::$instance;
    }

    public function registerEvents() {
        foreach ([
                     new PlayerEvents(),
                     new EntityEvents(),
                 ] as $event) {
            $this->getServer()->getPluginManager()->registerEvents($event);
        }
    }

    
    public function findPlayerGame(string $player) : string {
        // TODO
    }
    


    public function sendPlayerToGame(string $player, int $coords) {
        // TODO
  }

    public function isInAnyGame(string $player) {
        // TODO
    }


    public function isInGame(string $player) {
        if (isInAnyGame($player)) return true;
    }

    public function getOpponents(string $player) {
        // TODO
    }

    public function getAreas() {
        $areas = new Areas($this);
        $this->return($areas);
    }

    public function getEnemyBlock(string $player) {

    }

    public function isInTower(Player $player) {
        if ($this->getAreas()->isInTower($player)) return true;
    }

    public function unscheduleTask($id) {
        unset ($this->Tasks[$id]);
        $this->getScheduler()->cancelTask($id);
    }

    public function getMessages(string $msg, Player $player) : string {
        $messages = new api\game\Messages();
        $message = $messages->getMessage($msg, $player);
        return $message;
    }
}

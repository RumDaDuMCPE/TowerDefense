<?php

namespace TowerDefense;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use TowerDefense\api\Utils;
use TowerDefense\Events\{
    PlayerEvents,
    EntityEvents
}

class Loader extends PluginBase implements Listener {

    /** @var Loader */
    private static $sInstance;

    public $tasks = [];

    public function onEnable() {
        Utils::enable();
        $this->registerEvents();

    }

    public static function get() {
        if(is_null(self::$sInstance)) { self::$sInstance = new self(); }
        return self::$sInstance;
    }

    public function registerEvents() {
        foreach ([
                     new PlayerEvents(),
                     new EntityEvents(),
                 ] as $event) {
            $this->getServer()->getPluginManager()->registerEvents($event);
        }
    }

    public function sendPlayerToGame(string $player, int $coords) {
        // TODO
    }

    public function getOpponents(string $player) : array {
        // TODO
    }

    public function getAreas() {
        $areas = new Areas($this);
        $this->return($areas);
    }

    public function getEnemyBlock(string $player) {

    }

    public function isInTower(Player $player) : bool { // Checks if player is in in ANY Tone of the towers.
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
    
    public function onDisable() {
        Utils::disable();
    }
}

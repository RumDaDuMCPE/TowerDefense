<?php

namespace TowerDefense;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use TowerDefense\Utils;
use TowerDefense\system\UpdateHandler;
use TowerDefense\Events\{
    PlayerEvents,
    EntityEvents
}

class Loader extends PluginBase implements Listener {

    /** @var Loader */
    private static $sInstance;
    /** @var UpdateHandler */
    private static $sUpdateHandler;

    public $tasks = [];

    public function onEnable() {
        $this->registerEvents();
    }

    public static function get(): Loader {
        if(is_null(self::$sInstance)) { self::$sInstance = new self(); }
        return self::$sInstance;
    }

    public static function getUpdateHandler(): UpdateHandler {
        if(is_null(self::$sUpdateHandler)) { self::$sUpdateHandler = new UpdateHandler(self::get()->getServer()->getLoader(), self::get()->getServer()->getLogger()); }
        return self::$sUpdateHandler;
    }
    
    public function registerEvents() {
        foreach ([
                     new PlayerEvents(),
                     new EntityEvents(),
                 ] as $event) {
            $this->getServer()->getPluginManager()->registerEvents($event);
        }
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
        
    }
}

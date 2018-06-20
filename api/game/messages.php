<?php

namespace TowerDefense\api;

use pocketmine\utils\TextFormat;
use pocketmine\Player;

class messages {
    public function getMessages(string $msg, Player $player) : string {
        $messages = [
            "breach" => "&cYour tower is being breached by &6".$player->getName()."&r&c!",
            "error" => "&4ERROR FETCHING MESSAGE!"
        ];

        foreach ($messages as $message) {
            TextFormat::colorize($message);
        }

        switch ($msg) {
            case "breach":
                return $messages["breach"];
                break;
            default:
                return $messages["error"];
                break;
        }
    }
}

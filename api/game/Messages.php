<?php

namespace TowerDefense\api\game;

use pocketmine\utils\TextFormat;
use pocketmine\Player;

class messages {
    public function getMessage(string $msg, Player $player) : string {
        $messages = [
            "breach" => "&cYour tower is being breached by &6".$player->getName()."&r&c!",
            "extraction.successul" => "&aYou have successfully extracted the block!\n&e&lMake it to your tower to complete the extraction!",
            "error" => "&4ERROR FETCHING MESSAGE!"
        ];

        foreach ($messages as $message) {
            TextFormat::colorize($message);
        }

        switch ($msg) {
            case "breach":
                return $messages["breach"];
                break;
            case "extraction.successful":
                return $messages["extraction.successful"];
                break;
            default:
                return $messages["error"];
                break;
        }
    }
}

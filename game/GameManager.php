<?php

namespace TowerDefense\game;

use TowerDefense\api\game\entities\GameMap;

class GameManager {
    private static $instance;
    
    private $games = [];
    
    public function __construst() {
        self::$instance = $this;
    }
    
    public static function get() {
        return self::$instance;
    }
    
    public function getGame(string $id): Game {
        return isset($this->games[$id]) ? $this->games[$id] : null;
    }
    
    public function getGames(): array {
        return $this->games;
    }
    
    public function createGame(string $id, GameMap $map): Game {
        $game = new Game($id, [], [], $map);
        $this->games[$id] = $game;
        return $game;
    }
    
    //TODO
    public function loadGamesFromSigns() {}
}

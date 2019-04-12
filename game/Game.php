<?php
namespace TowerDefence\game;

use TowerDefence\api\game\entities\GameMap;
use TowerDefence\api\game\entities\Team;

class Game {
    private $id;
    private $teams = [];
    private $towers = [];
    private $map;
    
    public function __construct($id, $teams, $towers, GameMap $map) {
        $this->id = $id;
        $this->teams = $teams;
        $this->towers = $towers;
        $this->map = $map;
    }
    
    public function getId(): string {
        return $this->id;
    }
    
    public function getMap(): GameMap {
        return $this->map;
    }
    
    public function getTeams(): string {
        return $this->teams;
    }
    
    public function addTeam(string $name, $maxMembers, int $towerType): Team {
        if(!isset($this->teams[$name])) {
            $team = new Team($name, $maxMembers, $towerType, $this);
            $this->teams[$name] = $team;
            $team->getTower()->construct();
            return $team;
        }
        return null;
    }
    
    public function removeTeam($name): bool {
        if(isset[$this->teams[$name]) {
            unset($this->teams[$name]);
            return true;
        }
        return false;
    }
                 
    public function getTowers(): array {
        return $this->towers;
    }
    //TODO
    public function process(): void {}
}

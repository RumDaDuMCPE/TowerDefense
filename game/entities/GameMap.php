<?php

namespace TowerDefense\game\entities;

use TowerDefense\Loader;
use TowerDefense\system\Schematic;
use pocketmine\utils\BinaryStream;
use pocketmine\nbt\BigEndianNbtSerializer;

class GameMap {
  /** @var string */
  private $mName;
  
  public function __construct(string $pName) {
    $this->mName = $pName;
  }
  
  public function getName(): string {
    return $this->mName;
  }
  
  public static function load(string $pName): ?GameMap {
     if(!file_exists($file = Loader::get()->getDataFolder() . "maps/" . $pName . ".map")) return;
     $stream = new BinaryStream($file);
     $map = new GameMap($pName);
     $schematic = new Schematic();
     $schematic->parse($stream->get($stream->getUnsignedVarInt()));
     $map->setSchematic($schematic);
     return $map;
  }
}
